<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Email;
use App\User;
use App\UserEmail;
use Auth;
use Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomMail;
use App\Http\Requests\CreateEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use Intervention\Image\ImageManager;




class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmailRequest $request)
    {
        //
        $email = new Email;
        $email->title = $request->title;
        $email->content = $request->content;
        $email->create_user_id = Auth::id();
        $email->update_user_id = Auth::id();
        $email->save();

        return \Response::json(array('status' => '200', 'message' => 'Tạo email thông báo thành công!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UpdateEmailRequest $request)
    {
        $email = Email::find($request->id);
        if($email){
                $email->title = $request->title;
                $email->content = $request->content;
                $email->update_user_id = Auth::id();

                $email->save();

                return \Response::json(array('status' => '200', 'message' => 'Sửa email thông báo thành công!'));
            if($request->content != ''){
                return \Response::json(array('status' => '404', 'message' => 'Chưa điền nội dung email'));

            }
        }else{
            return \Response::json(array('status' => '404', 'message' => 'Không tìm thấy email trong hệ thống'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $email = Email::find($request->emailId);
        if($email){
            $email->delete();
            return response()->json(array('status' => '200', 'message' => 'Email đã được xóa!'));
        }else{
            return response()->json(array('status'=> '404', 'message' => 'Không tìm thấy email!'));
        }
    }

    /**
     * Remove the multiple emails by id from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple(Request $request)
    {
        $email_id_list = $request->email_id_list;

        // check if emails exist
        foreach ($email_id_list as $key => $email_id) {
            if(!Email::find($email_id)){
                return response()->json(array('status' => '400', 'message' => 'Có email không được tìm thấy'));
            }
        }

        \DB::table('emails')->whereIn('id', $email_id_list)->delete();

        return response()->json(array('status' => '200', 'message' => 'Các email đã bị xóa!'));
    }

    public function sendEmail(Request $request){

        $user = User::find($request->user_id);
        $email = Email::find($request->template_id);
        $email_template = new CustomMail($user, $email);
        Mail::to($user)->queue($email_template);

        $user_email  = new UserEmail;
        $user_email->user_id = $request->user_id;
        $user_email->email_id = $request->template_id;
        $user_email->sender_user_id = Auth::id();
        $user_email->title = $email_template->getEmail()->title;
        $user_email->content = $email_template->getEmail()->content;
        $user_email->save();

        if(Mail::failures()){
            return Response::json([
                'status'  => '404',
                'message' => 'Không gửi được email!'
            ]);
        }
        return Response::json([
            'status'  => '200',
            'message' => "Email đã được gửi thành công!"
        ]);
    }

    public function sendMultiple(Request $request)
    {
        $user_id_list = $request->user_id_list;
        $email = Email::find($request->template_id);
        foreach ($user_id_list as $key => $user_id) {
            if(!User::find($user_id)){
                return response()->json([
                    'status' => '400',
                    'message' => 'Không tìm thấy id người nhận'
                ]);
            }
        }
        $user_list = User::whereIn('id', $user_id_list)->get();

        foreach ($user_list as $key => $user) {
            $email_template = new CustomMail($user, $email);
            Mail::to($user)->queue($email_template);
            $user_email  = new UserEmail;
            $user_email->user_id = $user->id;
            $user_email->email_id = $email_template->getEmail()->id;
            $user_email->sender_user_id = Auth::id();
            $user_email->title = $email_template->getEmail()->title;
            $user_email->content = $email_template->getEmail()->content;
            $user_email->save();


            if(Mail::failures()){
                return Response::json([
                    'status'  => '404',
                    'message' => 'Đã có vấn đề xảy ra!'
                ]);
            }

        }

        return Response::json([
            'status'  => '200',
            'message' => "Email đã được gửi thành công!"
        ]);
    }

    public function uploadEmailPhoto(Request $request){
        $file = $request->file('upload');
        if(isset($file)){
            $mimeType = $file->getMimeType();
            $file_name = time().'_'.$file->getClientOriginalName();
            if(strpos($mimeType, 'image') !== false){
                $manager = new ImageManager(array('driver' => 'imagick'));
                $image = $manager->make($file);
                $image->save(public_path('backend/images/'.$file_name));
                // dd('true');
                return response()->json([
                    'fileName' => baseName($file_name),
                    'uploaded' => 1,
                    'url'      => url('backend/images/'.$file_name)
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Không phải file ảnh!',
                ]);
            }
        }
    }
}
