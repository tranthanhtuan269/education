<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\CommentVideo;

class CommentController extends Controller
{  
   public function store(Request $request){
      // dd($request);
      $commentVideo = new CommentVideo;
      $commentVideo->user_id = \Auth::id();
      $commentVideo->video_id = $request->videoId;
      $commentVideo->content = $request->content;
      $commentVideo->parent_id = 0;
      
      $commentVideo->save();

      return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentVideo' => $commentVideo));
   }
   public function createVideoComment($userId, $videoId){
        
   }
}
