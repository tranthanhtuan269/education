<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\CommentCourse;
use Auth;

class CommentCourseTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(CommentCourse $commentCourse)
    {
        
        return [
            'id' => $commentCourse->id,
            'parentId' => $commentCourse->parent_id,
            'username' => Auth::user()->name,
            'avatar' => Auth::user()->avatar,
            'userType' => $commentCourse->userRole->role_id == 1 ? "Student" : ($commentCourse->userRole->role_id == 2 ? "Teacher" : ""),
            'content' => $commentCourse->content,
            'created_at' => $commentCourse->created_at->format('Y-m-d H:i:s')
        ];
    }
}
