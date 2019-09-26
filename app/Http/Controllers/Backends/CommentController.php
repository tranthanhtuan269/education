<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    
    public function getAllCommentCourse()
    {
        return view('backends.comments.comment-course.all');

    }

    public function getAllCommentCourseAjax(Request $request)
    {
        $comments = Comment::all();
        return datatables()->collection($comments)
            ->addColumn('action', function ($comment) {
                return $comment->id;
            })->removeColumn('id')->make(true);
    }
}