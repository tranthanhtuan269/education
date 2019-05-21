<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\CommentVideo;
use Auth;

class CommentVideoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(CommentVideo $commentVideo)
    {
        return [
            'id' => $commentVideo->id,
            'parentId' => $commentVideo->parent_id,
            'username' => Auth::user()->name,
            'avatar' => Auth::user()->avatar,
            'userType' => $commentVideo->userRole->role_id == 1 ? "Student" : ($commentVideo->userRole->role_id == 2 ? "Teacher" : ""),
            'content' => $commentVideo->content,
            'created_at' => $commentVideo->created_at->format('Y-m-d H:i:s')
        ];
    }
}