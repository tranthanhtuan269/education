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
        $userType = 'Học viên';
        if($commentVideo->userRole){
            switch($commentVideo->userRole->role_id){
                case 1:
                    $userType = 'Người quản trị';
                case 2:
                    $userType = 'Giảng viên';
                    break;
                case 3:
                    $userType = 'Học viên';
                    break;
            }
        }
        
        
        return [
            'id' => $commentVideo->id,
            'parentId' => $commentVideo->parent_id,
            'username' => Auth::user()->name,
            'avatar' => Auth::user()->avatar,
            'userType' => $userType,
            'content' => $commentVideo->content,
            'created_at' => $commentVideo->created_at->format('Y-m-d H:i:s')
        ];
    }
}
