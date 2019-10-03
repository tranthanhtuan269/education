<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\CommentCourse;
use App\UserRole;
use App\User;

class CommentController extends Controller
{
    
    public function getAllCommentCourse()
    {
        return view('backends.comments.comment-course.all');

    }

    public function getAllCommentCourseAjax(Request $request)
    {
        // $comments = CommentCourse::get();
        $comments = \DB::table('comment_courses')
        ->join('user_roles', 'comment_courses.user_role_id', '=', 'user_roles.id')
        ->join('users', 'user_roles.user_id', '=', 'users.id')
        ->join('courses', 'courses.id', '=', 'comment_courses.course_id')
        ->where('users.status', 1)
        ->select('comment_courses.content', 'comment_courses.created_at', 'comment_courses.id', 'users.name as user_name', 'courses.name as course_name', 'courses.slug as course_slug')
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
}