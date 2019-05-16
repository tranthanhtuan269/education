<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\CommentVideo;
use App\Transformers\CommentTransformer;

class CommentController extends Controller
{  
   public function store(Request $request){
      dd($request);
      $commentCourse = new CommentCourse;
      $commentCourse->content = $request->content;
      $commentCourse->user_id = \Auth::id();
      $commentCourse->course_id = $request->course_id;
      $commentCourse->parent_id = 0;
      $commentCourse->state = 0;
      $commentCourse->save();

      return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentVideo' => fractal($commentVideo, new CommentTransformer())->toArray()));
   }
   
   public function createVideoComment($userId, $videoId){
        
   }
}
