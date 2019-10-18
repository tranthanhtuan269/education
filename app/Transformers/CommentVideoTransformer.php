<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\CommentVideo;
use Auth;

class CommentVideoTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['children'];
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
            'username' => $commentVideo->userRole->user->name,
            'avatar' => $commentVideo->userRole->user->avatar,
            'userType' => $this->getUserType($commentVideo),
            'content' => $commentVideo->content,
            'created_at' => $commentVideo->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function includeChildren(CommentVideo $commentVideo)
    {
        return $this->collection($commentVideo->children, new CommentVideoTransformer);
    }

    public function getUserType($commentVideo){
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
        return $userType;
    }
}
