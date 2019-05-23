<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\Course;
use App\Unit;
use App\Video;
use App\Note;
use App\Document;
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
        $course = Course::find($courseId);
        $main_video = Video::where('id', $videoId)->first();
        $units = Unit::where('course_id', $courseId)->get();
        $notes = Note::where('video_id', $videoId)->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $files = Document::where('video_id', $videoId)->orderBy('created_at', 'desc')->get();
        $user_role_course_instance = Helper::getUserRoleOfCourse($courseId);
        
        if($user_role_course_instance == null) abort(403, 'Unauthorized action.');

        $user_role_id = $user_role_course_instance->user_role_id;

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
        ->orderBy('created_at', 'desc')
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
        ->orderBy('created_at', 'asc')
        ->get();

        // $main_video_id = $main_video->unit->course->id; 
        $video_id_list = [];
        foreach ($units as $unit) {
            foreach ($unit->videos as $key => $video) {
                array_push($video_id_list, $video->id);
            }
        }
        
        $main_video_id_key = null;
        foreach ($video_id_list as $key => $value) {
            if($value == $videoId){
                $main_video_id_key = $key;
            }
        }

        return view('frontends.learning-page.index', [
            'course'             => $course,
            'units'              => $units,
            'notes'              => $notes,
            'files'              => $files,
            'video_id_list'      => $video_id_list,
            'comments_video'     => $comments_video,
            'sub_comments_video' => $sub_comments_video,
            'main_video'         => $main_video,
            'main_video_id_key'  => $main_video_id_key,
            'user_role_course_instance' => $user_role_course_instance,
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
