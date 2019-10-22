<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Helper\Helper;
use App\User;
use App\UserRole;
use App\Teacher;
use Carbon\Carbon;
use Config;
use Hash;
use Image;

class StudentController extends Controller
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
     * @Author: DuongNT
     * 
     * Store a newly created resource in storage.
     * 
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request) 
    {
        $current_time=time();
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

        $user_role_student = new UserRole;
        $user_role_student->user_id = $user->id;
        $user_role_student->role_id = Config::get('app.student');
        $user_role_student->save();

        \App\Helper\Helper::addAlert($user, "app.email_active_user");

        return response()->json([
            'status' => 200,
            'message' => 'Thêm học viên thành công!'
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request)
    {
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
            
            return response()->json([
                'status' => 200,
                'message' => 'Sửa thành công'
            ]);

        }else{
            return response()->json([
                'status' => '404',
                'message' => 'Không tìm thấy tài khoản!'
            ]);
        }
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
}
