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
use App\Transformers\VideoPlayerLectureListTransformer;
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
    public function show($courseId, $videoId = 0)
    {
        $course = Course::find($courseId);
        if($course){
            $user_role_course_instance = Helper::getUserRoleOfCourse($courseId);

            // dd($user_role_course_instance);
            if($user_role_course_instance == null) abort(403, 'Unauthorized action.');
            if($videoId == 0){
                $videoId = json_decode($user_role_course_instance->videos)->learning_id;
            }
            $main_video = Video::where('id', $videoId)->first();
            $units = Unit::where('course_id', $courseId)->get();
            $notes = Note::where('video_id', $videoId)->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
            $files = Document::where('video_id', $videoId)->orderBy('created_at', 'desc')->get();

            $user_role_id = $user_role_course_instance->user_role_id;
            if(Auth::user()->isAdmin()){
                $comments_video = CommentVideo::where(
                    function($q) use ($user_role_id){
                        $q->where(function($q2) use ($user_role_id){
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
                        $q->where(function($q2) use ($user_role_id){
                            $q2->where('user_role_id', $user_role_id);
                        });
                }
                )
                ->where('video_id', $videoId)
                ->where('parent_id', "!=", 0)
                ->orderBy('created_at', 'asc')
                ->get();

            }else{
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
                // dd($comments_video);
                // foreach($comments_video as $comment_video){
                //     $comment_video->delete();
                // }

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
            }

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

    // DuongNT // đổi 0 thành 1 ở vị trí video vừa click trong array video đã xem
    public function updateWatched(Request $request){
        $video = Video::whereIn('state', [1,2,4])->find($request->video_id);
        // dd($video);
        if($video){
            $unit = $video->unit;
            $course = $video->unit->course;
            $user_course = Helper::getUserRoleOfCourse($course->id);
            // dd($user_course);
            if($user_course){
                $videos = $user_course->videos;
                if($videos == null){
                    return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!'));
                }
                $videoObj = \json_decode($videos);
                $videoObj->videos = $videoObj->videos;
                $update_viewed = 0;
                if(is_array($videoObj->videos[$unit->index-1])){
                    if($videoObj->videos[$unit->index-1][$video->index-1] == 0){
                        $update_viewed = 1;
                    }
                    $videoObj->videos[$unit->index-1][$video->index-1] = 1;
                }else{
                    $videoObj->videos[0][$video->index-1] = 1;
                }

                $videoObj->learning = $video->index;
                $videoObj->learning_id = $video->id;

                $videoData = \json_encode($videoObj);
                $user_course->videos = $videoData;
                $user_course->save();

                $video_urls = json_decode($video->url_video, true);
                foreach ($video_urls as $key => $video_url) {
                    $video_urls[$key] = \App\Helper::createSecurityTokenForVideoLink(\Auth::id(), $video->id, $video_url);
                }    
                $video_list = json_encode($video_urls);

                $count_note = Note::where('video_id', $request->videoId)->get()->count();

                return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'update_viewed' => $update_viewed, 'video_url' => $video_list, 'count_note' => $count_note));
            }
        }

        return \Response::json(array('status' => '404', 'message' => 'Video không tồn tại!'));
    }

    // DuongNT // đổi 0 thành 1 ở vị trí video vừa click trong array video đã xem
    public function getInfoCourse(Request $request){
        $video = Video::whereIn('state', [1,2,4])->find($request->video_id);
        // dd($video);
        if($video){
            $unit = $video->unit;
            $course = $video->unit->course;
            $user_course = Helper::getUserRoleOfCourse($course->id);
            // dd($user_course);
            if($user_course){
                $video_urls = json_decode($video->url_video, true);
                foreach ($video_urls as $key => $video_url) {
                    $video_urls[$key] = \App\Helper::createSecurityTokenForVideoLink(\Auth::id(), $video->id, $video_url);
                }    
                $video_list = json_encode($video_urls);

                $videos = $user_course->videos;
                if($videos == null){
                    // teacher
                    return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'update_viewed' => 1, 'video_url' => $video_list));
                }
                return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'update_viewed' => 1, 'video_url' => $video_list));
            }
        }

        return \Response::json(array('status' => '404', 'message' => 'Video không tồn tại!'));
    }

    // DuongNT // đổi 0 thành 1 ở vị trí video vừa click trong array video đã xem
    public function updateNotWatched(Request $request){
        $video = Video::whereIn('state', [1,2,4])->find($request->video_id);
        // dd($video);
        if($video){
            $unit = $video->unit;
            $course = $video->unit->course;
            $user_course = Helper::getUserRoleOfCourse($course->id);
            // dd($user_course);
            if($user_course){
                $videos = $user_course->videos;
                if($videos == null){
                    return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!'));
                }
                $videoObj = \json_decode($videos);
                $videoObj->videos = $videoObj->videos;
                if(is_array($videoObj->videos[$unit->index-1])){
                    $videoObj->videos[$unit->index-1][$video->index-1] = 0;
                }else{
                    $videoObj->videos[0][$video->index-1] = 0;
                }

                $videoObj->learning = $video->index;
                $videoObj->learning_id = $video->id;

                $videoData = \json_encode($videoObj);
                $user_course->videos = $videoData;
                $user_course->save();
                return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!'));
            }
        }

        return \Response::json(array('status' => '404', 'message' => 'Video không tồn tại!'));
    }

    public function searchLectureList(Request $request){
        $courseId = $request->courseId;
        if($request->content){
            $units =  Unit::where('course_id', $courseId)->get();
            $video_list = [];
            $unit_id_list = [];
            foreach ($units as $key => $unit) {
                array_push($unit_id_list, $unit->id);
                $videos = Video::where('unit_id',$unit->id)->where("name", "LIKE", "%$request->content%")->get();
                foreach($videos as $video){
                    array_push($video_list, $video);
                }
            }
            return \Response::json(array('status' => '200', 'message' => 'Success', 'videoList' =>  fractal($video_list, new VideoPlayerLectureListTransformer())->toArray()  ));
        }else{
            return \Response::json(array('status' => '404', 'message' => 'Nothing'));
        }
    }

    public function getNoteCount(Request $request){
        $note_count = \App\Note::where('video_id', $request->video_id)->get()->count();
        $comment_count = \App\CommentVideo::where('video_id', $request->video_id)->get()->count();
        $document_count = \App\Document::where('video_id', $request->video_id)->get()->count();
        return \Response::json(array(
            'status' => '200', 
            'note_count' => $note_count, 
            'comment_count'=>$comment_count, 
            'document_count'=>$document_count
        ));
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
