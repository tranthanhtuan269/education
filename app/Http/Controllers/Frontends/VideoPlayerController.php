<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\Course;
use App\Unit;
use App\Video;
use App\CommentVideo;
use App\UserCourse;
use App\UserRole;
use App\Helper\Helper;
use Auth;

class VideoPlayerController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($courseId, $videoId)
    {   
        $demanding_user_role_item = Helper::getUserRoleOfCourse($courseId);
        if($demanding_user_role_item == null) abort(403, 'Unauthorized action.');
        
        //1: Student, 2: Teacher
        if($demanding_user_role_item->status == 1){
            $demanding_user_role = "Student";
        }else if($demanding_user_role_item->status == 2){
            $demanding_user_role = "Teacher";
        }

        $user_role_id = $demanding_user_role_item->user_role_id;


        $main_video = Video::where('id', $videoId)->first();
        $units = Unit::where('course_id', $courseId)->get();

        $comments_video = CommentVideo::where(
            function($q) use ($user_role_id){
                $q->where('state', 1)
                ->orWhere(function($q2) use ($user_role_id){
                    $q2->where('user_role_id', $user_role_id);
                });
           }
        )
        ->where('video_id', $videoId)
        ->where('parent_id', 0)
        ->get();

        $sub_comments_video = CommentVideo::where(
            function($q) use ($user_role_id){
                $q->where('state', 1)
                ->orWhere(function($q2) use ($user_role_id){
                    $q2->where('user_role_id', $user_role_id);
                });
           }
        )
        ->where('video_id', $videoId)
        ->where('parent_id', "!=", 0)
        ->get();

        $course = Course::find($courseId);
        $unit_list = [];
        foreach ($units as $unit) {
            $singleVideo = Video::where('unit_id', $unit->id)->get();
            array_push($unit_list, $singleVideo);
        }
        return view('frontends.learning-page.index', [
            'course'         => $course,
            'units'          => $units,
            'unit_list'      => $unit_list,
            'comments_video' => $comments_video,
            'sub_comments_video' => $sub_comments_video,
            'main_video'     => $main_video,
        ]);
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
