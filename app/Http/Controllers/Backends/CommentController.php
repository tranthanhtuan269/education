<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\CommentCourse;
use App\CommentVideo;
use App\UserRole;
use App\User;

class CommentController extends Controller
{
    
    public function getAllCommentCourse()
    {
        return view('backends.comments.comment-course.all');

    }

    public function getAllCommentVideo()
    {
        return view('backends.comments.comment-videos');

    }

    public function getAllCommentCourseAjax(Request $request)
    {
        // $comments = CommentCourse::get();
        $comments = \DB::table('comment_courses')
        ->join('user_roles', 'comment_courses.user_role_id', '=', 'user_roles.id')
        ->join('users', 'user_roles.user_id', '=', 'users.id')
        ->join('courses', 'courses.id', '=', 'comment_courses.course_id')
        ->where('users.status', 1)
        ->select('comment_courses.content', 'comment_courses.created_at', 'comment_courses.id', 'users.name as user_name', 'courses.name as course_name', 'courses.slug as course_slug', 'courses.id as course_id')
        ->get();

        // dd($comments);
        return datatables()->collection($comments)
            ->addColumn('action', function ($comment) {
                return $comment->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function getAllCommentVideoAjax(Request $request)
    {
        // $comments = CommentCourse::get();
        $comments = \DB::table('comment_videos')
        ->join('user_roles', 'comment_videos.user_role_id', '=', 'user_roles.id')
        ->join('users', 'user_roles.user_id', '=', 'users.id')
        ->join('videos', 'videos.id', '=', 'comment_videos.video_id')
        ->join('units', 'units.id', '=', 'videos.unit_id')
        ->join('courses', 'courses.id', '=', 'units.course_id')
        ->where('users.status', 1)
        ->select('comment_videos.content', 'comment_videos.created_at', 'comment_videos.id', 'users.name as user_name', 'videos.name as video_name', 'courses.id as course_id', 'comment_videos.id')
        ->get();
        // dd($comments);
        return datatables()->collection($comments)
            ->addColumn('action', function ($comment) {
                return $comment->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function deleteCommentCourse(Request $request)
    {
        $comment = CommentCourse::find($request->id);

        if( $comment ){
            if( $comment->parent_id != 0 ){
                $comment->delete();
                return \Response::json(['message' => 'Xóa phản hồi khóa học thành công.', 'status' => 200]);
            }else{
                $child_comments = CommentCourse::where('parent_id', $comment->id)->get();
                
                if( $child_comments ){
                    foreach( $child_comments as $child_comment ){
                        $child_comment->delete();
                    }
                    $comment->delete();
                    return \Response::json(['message' => 'Xóa phản hồi khóa học thành công.', 'status' => 200]);
                }
                return \Response::json(['message' => 'Xóa phản hồi khóa học thành công.', 'status' => 200]);
            }
        }
        return \Response::json(['message' => 'Không tìm thấy.', 'status' => 404]);
    }

    public function getAllCommentReport()
    {
        return view('backends.comments.comment-report.all');

    }

    public function getAllCommentReportAjax(Request $request)
    {
        $comments = \DB::table('comment_courses')
        ->join('user_roles', 'comment_courses.user_role_id', '=', 'user_roles.id')
        ->join('users', 'user_roles.user_id', '=', 'users.id')
        ->join('courses', 'comment_courses.course_id', '=', 'courses.id')
        ->where('comment_courses.state', 1)
        ->select('comment_courses.content', 'comment_courses.created_at', 'comment_courses.id', 'users.name as user_name', 'courses.name as course_name','courses.id as course_id', 'courses.slug as course_slug')
        ->get();
        return datatables()->collection($comments)
            ->addColumn('action', function ($comment) {
                return $comment->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function deleteReportCourse(Request $request)
    {
        $comment = CommentCourse::find($request->id);

        if( $comment ){
            if( $comment->parent_id != 0 ){
                $comment->delete();
                return \Response::json(['message' => 'Xóa phản hồi comment thành công.', 'status' => 200]);
            }else{
                $child_comments = CommentCourse::where('parent_id', $comment->id)->get();
                
                if( $child_comments ){
                    foreach( $child_comments as $child_comment ){
                        $child_comment->delete();
                    }
                    $comment->delete();
                    return \Response::json(['message' => 'Xóa phản hồi comment thành công.', 'status' => 200]);
                }
                return \Response::json(['message' => 'Xóa phản hồi comment thành công.', 'status' => 200]);
            }
        }
        return \Response::json(['message' => 'Không tìm thấy comment.', 'status' => 404]);
    }

    public function cancelComment(Request $request)
    {
        $comment = CommentCourse::find($request->comment_id);
        if($comment){
            $comment->state = $request->state;
            $comment->save();
            return \Response::json(array('status' => '200', 'message' => 'Thêm like thành công!'));
        }
        return \Response::json(array('status' => '404', 'message' => 'Comment không tồn tại!'));
    }
}