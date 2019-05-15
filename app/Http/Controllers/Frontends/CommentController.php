<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\CommentVideo;
use App\Transformers\CommentTransformer;

class CommentController extends Controller
{  
   public function store(Request $request){
      
      $commentVideo = new CommentVideo;
      $commentVideo->user_role_id = \Auth::id();
      $commentVideo->video_id = $request->videoId;
      $commentVideo->content = $request->content;
      if(isset($request->parentId)){
         $commentVideo->parent_id = $request->parentId;
      }
      // dd($commentVideo->parent_id);
      $commentVideo->save();
      

      return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentVideo' => fractal($commentVideo, new CommentTransformer())->toArray()));
   }
   public function createVideoComment($userId, $videoId){
        
   }
}
