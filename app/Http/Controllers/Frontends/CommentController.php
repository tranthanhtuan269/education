<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\CommentVideo;
use App\CommentCourse;
use App\Transformers\CommentTransformer;

class CommentController extends Controller
{  
   public function store(Request $request){
      // dd($request);
      $commentVideo = new CommentVideo;
      $commentVideo->user_role_id = \Auth::id();
      $commentVideo->video_id = $request->videoId;
      $commentVideo->content = $request->content;
      $commentVideo->parent_id = 0;
      
      $commentVideo->save();

      return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentVideo' => fractal($commentVideo, new CommentTransformer())->toArray()));
   }

   public function commentCourse(Request $request){
      // dd($request);
      $commentCourse = new CommentCourse;
      $commentCourse->content = $request->content;
      $commentCourse->course_id = $request->course_id;
      $commentCourse->state = $request->state;
      $commentCourse->user_id = \Auth::id();
      $commentCourse->parent_id = $request->parent_id;
      $commentCourse->save();

      return \Response::json(array('status' => '200', 'message' => 'Bình luận thông tin đã thành công!'));
   }

   public function createVideoComment($userId, $videoId){
        
   }
}
