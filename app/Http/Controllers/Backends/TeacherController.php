<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherRequest;
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
        $avatar = $request->avatar;
        $cropped_avatar = Image::make($avatar)
        ->resize(300, 300)
        ->save(public_path('uploads/'.time().'_avatar'.'.png'));

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->birthday = Helper::formatDate('d/m/Y', $request->dob, 'Y-m-d');
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->avatar = time().'_avatar'.'.png';
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
