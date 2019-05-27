<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use Auth;
use App\Video;
use App\Course;
use App\CommentLike;
use App\RatingCourse;
use App\CommentVideo;
use App\CommentCourse;
use App\Transformers\CommentVideoTransformer;
use App\Transformers\CommentCourseTransformer;
use App\Helper\Helper;

class CommentController extends Controller
{  
   // Mấy chức năng trong phần comment này
   // đều phải đăng nhập mới thực hiện được
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function storeCommentVideo(Request $request){
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
         $commentVideo->save();
         return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentVideo' => fractal($commentVideo, new CommentVideoTransformer())->toArray()));
      }
      return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
   }

   public function storeCommentCourse(Request $request){
      $course = Course::find($request->course_id);
      if($course){
         $commentCourse = new CommentCourse;
         $commentCourse->content = $request->content;
         $commentCourse->user_role_id = Helper::getUserRoleOfCourse($request->course_id)->user_role_id;
         $commentCourse->course_id = $request->course_id;
         if(isset($request->parentId)){
            $commentCourse->parent_id = $request->parentId;
         }
         $commentCourse->score = $request->score;
         $commentCourse->state = 0;
         $commentCourse->save();

         // Kiểm tra user đã rating từ trước chưa?
         // Nếu chưa thì add thêm vào bảng RatingCourse.
         // Nếu có rồi thì bỏ qua bước này.
         $check = RatingCourse::where('user_id', Auth::id())->where('course_id', $request->course_id)->first();
         if(!isset($check)){
            $ratingCourse = new RatingCourse;
            $ratingCourse->user_id = Auth::id();
            $ratingCourse->course_id = $request->course_id;
            $ratingCourse->score = $request->score;
            $ratingCourse->save();
            
            // Lưu vào table Courses
            switch($request->score){
               case 1: $course->one_stars += 1; break;
               case 2: $course->two_stars += 1; break;
               case 3: $course->three_stars += 1; break;
               case 4: $course->four_stars += 1; break;
               case 5: $course->five_stars += 1; break;
               default: break;
            }

            $course->star_count += $request->score;
            $course->vote_count += 1;
            $course->save();
         }
         return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentCourse' => fractal($commentCourse, new CommentCourseTransformer())->toArray()));
      }
      return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
   }

   public function updateStar(Request $request){
      $course = Course::find($request->course_id);
      if($course){
         $currentRating = RatingCourse::where('user_id', Auth::id())->where('course_id', $request->course_id)->first();
         if(!isset($currentRating)){
            return \Response::json(array('status' => '401', 'message' => 'Mời quay lại trang khóa học để review!')); 
         }else{
            switch($currentRating->score){
               case 1: $course->one_stars -= 1; break;
               case 2: $course->two_stars -= 1; break;
               case 3: $course->three_stars -= 1; break;
               case 4: $course->four_stars -= 1; break;
               case 5: $course->five_stars -= 1; break;
               default: break;
            }

            switch($request->score){
               case 1: $course->one_stars += 1; break;
               case 2: $course->two_stars += 1; break;
               case 3: $course->three_stars += 1; break;
               case 4: $course->four_stars += 1; break;
               case 5: $course->five_stars += 1; break;
               default: break;
            }
            $course->star_count += ($request->score - $currentRating->score);

            $commentCourse = CommentCourse::where('course_id', $request->course_id)->where('user_role_id',Helper::getUserRoleOfCourse($request->course_id)->user_role_id )->first();
            $commentCourse->score = $request->score;
            $commentCourse->save();

            $currentRating->score = $request->score;
            $currentRating->save();
         }
         return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!'));

      }
      return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
   }

   public function storeCommentVote(Request $request){
      $comment = CommentCourse::find($request->comment_id);
      if($comment){
         $commentLike = CommentLike::where('comment_id', $request->comment_id)->where('user_id', Auth::id())->first();
         if($commentLike){
            $commentLike->state = ($request->type == "up") ? 1 : -1;
            $commentLike->save();
         }else{
            $commentLike = new CommentLike;
            $commentLike->comment_id = $request->comment_id;
            $commentLike->user_id = Auth::id();
            $commentLike->state = ($request->type == "up") ? 1 : -1;
            $commentLike->save();
         }
         return \Response::json(array('status' => '200', 'message' => 'Thêm like thành công!', 'commentLike' => $commentLike));
      }
      return \Response::json(array('status' => '404', 'message' => 'Comment không tồn tại!'));
   }

   public function storeReply(Request $request){
      $comment = CommentCourse::find($request->parent_id);
      if($comment){
         $commentCourse = new CommentCourse;
         $commentCourse->content = $request->content;
         $commentCourse->user_role_id = Helper::getUserRoleOfCourse($comment->course->id)->user_role_id;
         $commentCourse->course_id = $comment->course_id;
         $commentCourse->parent_id = (int)$request->parent_id;
         $commentCourse->score = 0;
         $commentCourse->state = 0;
         $commentCourse->save();

         return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentCourse' => fractal($commentCourse, new CommentCourseTransformer())->toArray()));
      }
      return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
   }

   public function seeMore(Request $request){
      if($request->course_id != null && $request->take != null && $request->skip != null){
         $course = Course::find($request->course_id);
         if($course){
            $commentCourses = $course->takeComment($request->skip, $request->take);
            return view('components.question-answer-list', ['comments' => $commentCourses]);
         }
         return '';
      }
      return '';
   }
}
