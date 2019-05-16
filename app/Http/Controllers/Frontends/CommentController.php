<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\Video;
use App\CommentVideo;
use App\Transformers\CommentTransformer;
use App\Helper\Helper;

class CommentController extends Controller
{  
   public function store(Request $request){
      
      $video = Video::find($request->videoId);
      if($video){
         $courseId = $video->unit->course->id;
         $commentVideo = new CommentVideo;
         $commentVideo->user_role_id = Helper::getUserRoleOfCourse($courseId)->user_role_id;
         $commentVideo->video_id = $request->videoId;
         $commentVideo->content = $request->content;
         if(isset($request->parentId)){
            $commentVideo->parent_id = $request->parentId;
         }
         // dd($commentVideo->parent_id);
         $commentVideo->save();
         return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentVideo' => fractal($commentVideo, new CommentTransformer())->toArray()));
      }
      return \Response::json(array('status' => '404', 'message' => 'Course Id không tồn tại!'));
   }
   public function createVideoComment($userId, $videoId){
        
   }
}
