<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Helper\Helper;
use App\User;
use App\UserRole;
use App\Teacher;
use Carbon\Carbon;
use Config;
use Hash;
use Image;


class TeacherController extends Controller
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


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        $current_time = time();
        if($request->avatar){
            $avatar = $request->avatar;
            $cropped_avatar = Image::make($avatar)
            ->resize(300, 300)
            ->save(public_path('frontend/images/'.$current_time.'_avatar'.'.png'));
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birthday = Helper::formatDate('d/m/Y', $request->dob, 'Y-m-d');
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        if($request->avatar){
            $avatar = $request->avatar;
            $cropped_avatar = Image::make($avatar)
            ->resize(300, 300)
            ->save(public_path('frontend/images/'.$current_time.'_avatar'.'.png'));
            $user->avatar = 'images/'.$current_time.'_avatar'.'.png';
        }
        else{
            $user->avatar = 'images/avatar.jpg';
        }
        $user->status = 1;
        $user->password = Hash::make($request->password);
        $user->save();

        $user_role_teacher = new UserRole;
        $user_role_teacher->user_id = $user->id;
        $user_role_teacher->role_id = Config::get('app.teacher');
        $user_role_teacher->save();

        $teacher = new Teacher;
        $teacher->user_role_id = $user_role_teacher->id;
        $teacher->cv = $request->cv;
        $teacher->expert = $request->expert;
        $teacher->video_intro = $request->youtube;
        $teacher->status = Config::get('app.teacher_active');
        $teacher->save();

        $user_role_student = new UserRole;
        $user_role_student->user_id = $user->id;
        $user_role_student->role_id = Config::get('app.student');
        $user_role_student->save();

        return response()->json([
            'status' => 200,
            'message' => 'Thêm giảng viên thành công'
        ]);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   App\Http\Requests\UpdateTeacherRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request)
    {
        // dd($request->avatar);
        if(isset($request->avatar)){
            $avatar = $request->avatar;
            $cropped_avatar = Image::make($avatar)
            ->resize(300, 300)
            ->save(public_path('frontend/images/'.time().'_avatar'.'.png'));
        }

        $user = User::find($request->user_id);
        if(isset($user)){
            $user->name = $request->name;
            $user->birthday = Helper::formatDate('d/m/Y', $request->dob, 'Y-m-d');
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->gender = $request->gender;
            if(isset($request->avatar)){
                $user->avatar = 'images/'.time().'_avatar'.'.png';
            }
            if(isset($request->password)){
                $user->password = Hash::make($request->password);
            }
            $user->save();


            $user_role_teacher = $user->userRolesTeacher();
            if($user_role_teacher){     //check có user_role là teacher chưa (có trường hợp đã từng là teacher)
                $teacher = $user_role_teacher->teacher;
                if($teacher){
                    $teacher->cv = $request->cv;
                    $teacher->expert = $request->expert;
                    $teacher->video_intro = $request->youtube;
                    $teacher->status = \Config::get('app.teacher_active');
                    $teacher->save();
                }
                else{
                    $teacher = new Teacher;
                    $teacher->user_role_id = $user_role_teacher->id;
                    $teacher->cv = $request->cv;
                    $teacher->expert = $request->expert;
                    $teacher->video_intro = $request->youtube;
                    $teacher->status = Config::get('app.teacher_active');
                    $teacher->save();
                }
            }else{                  // chưa có user_role là teacher
                $user_role_teacher = new UserRole;
                $user_role_teacher->user_id = $user->id;
                $user_role_teacher->role_id = Config::get('app.teacher');
                $user_role_teacher->save();

                $teacher = new Teacher;
                $teacher->user_role_id = $user_role_teacher->id;
                $teacher->cv = $request->cv;
                $teacher->expert = $request->expert;
                $teacher->video_intro = $request->youtube;
                $teacher->status = Config::get('app.teacher_active');
                $teacher->save();
            }

        }else{
            return response()->json([
                'status' => '404',
                'message' => 'Không tìm thấy tài khoản!'
            ]);
        }

        // $user_role_teacher = new UserRole;
        // $user_role_teacher->user_id = $user->id;
        // $user_role_teacher->role_id = Config::get('app.teacher');
        // $user_role_teacher->save();

        // $teacher = new Teacher;
        // $teacher->user_role_id = $user_role_teacher->id;
        // $teacher->cv = $request->cv;
        // $teacher->expert = $request->expert;
        // $teacher->video_intro = $request->youtube;
        // $teacher->status = Config::get('app.teacher_active');
        // $teacher->save();

        // $user_role_student = new UserRole;
        // $user_role_student->user_id = $user->id;
        // $user_role_student->role_id = Config::get('app.student');
        // $user_role_student->save();

        return response()->json([
            'status' => 200,
            'message' => 'Sửa giảng viên thành công'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function disable(Request $request){
        $teacher_id = $request->teacher_id;
        if(isset($teacher_id)){
            $teacher = Teacher::find($teacher_id);
            if(isset($teacher)){
                
                if( $teacher->featured != 0 ){
                    return response()->json([
                        'status' => '302',
                        'message' => 'Không thể hủy giảng viên tiêu biểu.'
                    ]);
                }else{
                    $teacher->status = \Config::get('app.teacher_blocked');
                    $teacher->save();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Tắt chức năng giảng viên thành công!'
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Tài khoản không tồn tại!'
            ]);
        }
    }
}
