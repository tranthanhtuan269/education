<?php

namespace App\Http\Controllers\Frontends;

use App\CommentCourse;
use App\CommentLike;
use App\CommentVideo;
use App\Course;
use App\Teacher;
use App\Helper\Helper;
use App\RatingCourse;
use App\RatingTeacher;
use App\Transformers\CommentCourseTransformer;
use App\Transformers\CommentVideoTransformer;
use App\Video;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDiscussionRequest;

class CommentController extends Controller
{
    // Mấy chức năng trong phần comment này
    // đều phải đăng nhập mới thực hiện được
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeCommentVideo(StoreDiscussionRequest $request)
    {
        $video = Video::find($request->videoId);
        if ($video) {
            $courseId = $video->unit->course->id;
            $commentVideo = new CommentVideo;
            $commentVideo->user_role_id = Helper::getUserRoleOfCourse($courseId)->user_role_id;
            $commentVideo->video_id = $request->videoId;
            $commentVideo->content = $request->content;
            $commentVideo->state = 1;
            if (isset($request->parentId)) {
                $commentVideo->parent_id = $request->parentId;
            }
            $commentVideo->save();
            return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentVideo' => fractal($commentVideo, new CommentVideoTransformer())->toArray()));
        }
        return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
    }

    public function storeCommentCourse(Request $request)
    {
        $course = Course::find($request->course_id);
        if ($course) {
            // Kiểm tra user đã rating từ trước chưa?
            // Nếu chưa thì add thêm vào bảng RatingCourse.
            // Nếu có rồi thì bỏ qua bước này.
            $check = RatingCourse::where('user_id', Auth::id())->where('course_id', $request->course_id)->first();
            if (!isset($check)) {

                // add comment
                $commentCourse = new CommentCourse;
                $commentCourse->content = $request->content;
                $commentCourse->user_role_id = Auth::user()->userRolesStudent()->id;
                $commentCourse->course_id = $request->course_id;
                if (isset($request->parentId)) {
                    $commentCourse->parent_id = $request->parentId;
                }
                $commentCourse->score = $request->score;
                $commentCourse->state = 0;
                $commentCourse->save();
                // end add comment

                $ratingCourse = new RatingCourse;
                $ratingCourse->user_id = Auth::id();
                $ratingCourse->course_id = $request->course_id;
                $ratingCourse->score = $request->score;
                $ratingCourse->save();

                // Lưu vào table Courses
                switch ($request->score) {
                    case 1:$course->one_stars += 1;
                        break;
                    case 2:$course->two_stars += 1;
                        break;
                    case 3:$course->three_stars += 1;
                        break;
                    case 4:$course->four_stars += 1;
                        break;
                    case 5:$course->five_stars += 1;
                        break;
                    default:break;
                }

                $course->star_count += $request->score;
                $course->vote_count += 1;
                $course->save();
                return \Response::json(array('status' => '201', 'message' => 'Cập nhật thông tin thành công!', 'commentCourse' => fractal($commentCourse, new CommentCourseTransformer())->toArray(), 'course' => $course));
            }else{
                return \Response::json(array('status' => '200', 'message' => 'Bạn chỉ được gửi nhận xét một lần cho mỗi khóa học!'));
            }
        }
        return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
    }

    public function updateStar(Request $request)
    {
        // dd($request->all());
        $course = Course::find($request->course_id);
        if ($course) {
            $currentRating = RatingCourse::where('user_id', Auth::id())->where('course_id', $request->course_id)->first();
            if (!isset($currentRating)) {
                $commentCourse = new CommentCourse;
                if($request->review_text != null){
                    $commentCourse->content = $request->review_text;
                }
                $commentCourse->course_id = $request->course_id;
                $commentCourse->user_role_id = Helper::getUserRoleOfCourse($request->course_id)->user_role_id;
                if (isset($request->parentId)) {
                    $commentCourse->parent_id = $request->parentId;
                }
                $commentCourse->score = $request->score;
                $commentCourse->state = 0;
                $commentCourse->save();

                $check = RatingCourse::where('user_id', Auth::id())->where('course_id', $request->course_id)->first();
                if (!isset($check)) {
                    $ratingCourse = new RatingCourse;
                    $ratingCourse->user_id = Auth::id();
                    $ratingCourse->course_id = $request->course_id;
                    $ratingCourse->score = $request->score;
                    $ratingCourse->save();

                    // Lưu vào table Courses
                    switch ($request->score) {
                        case 1:$course->one_stars += 1;
                            break;
                        case 2:$course->two_stars += 1;
                            break;
                        case 3:$course->three_stars += 1;
                            break;
                        case 4:$course->four_stars += 1;
                            break;
                        case 5:$course->five_stars += 1;
                            break;
                        default:break;
                    }

                    $course->star_count += $request->score;
                    $course->vote_count += 1;
                    $course->save();
                }

                return \Response::json(array('status' => '200', 'message' => 'Thêm mới review aka comment_course thành công'));
            } else {
                switch ($currentRating->score) {
                    case 1:$course->one_stars -= 1;
                        break;
                    case 2:$course->two_stars -= 1;
                        break;
                    case 3:$course->three_stars -= 1;
                        break;
                    case 4:$course->four_stars -= 1;
                        break;
                    case 5:$course->five_stars -= 1;
                        break;
                    default:break;
                }

                switch ($request->score) {
                    case 1:$course->one_stars += 1;
                        break;
                    case 2:$course->two_stars += 1;
                        break;
                    case 3:$course->three_stars += 1;
                        break;
                    case 4:$course->four_stars += 1;
                        break;
                    case 5:$course->five_stars += 1;
                        break;
                    default:break;
                }
                $course->star_count += ($request->score - $currentRating->score);

                $commentCourse = CommentCourse::where('course_id', $request->course_id)->where('user_role_id', Helper::getUserRoleOfCourse($request->course_id)->user_role_id)->first();
                $commentCourse->score = $request->score;
                $commentCourse->save();

                $currentRating->score = $request->score;
                $currentRating->save();
            }
            return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!'));

        }
        return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
    }

    public function storeCommentVote(Request $request)
    {
        $comment = CommentCourse::find($request->comment_id);
        if ($comment) {
            $commentLike = CommentLike::where('comment_id', $request->comment_id)->where('user_id', Auth::id())->first();
            if ($commentLike) {
                $commentLike->state = ($request->type == "up") ? 1 : -1;
                $commentLike->save();
            } else {
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

    public function reportComment(Request $request)
    {
       
        $comment = CommentCourse::find( $request->comment_id);
        if ($comment) {
                $comment->state = 0;
                $comment->save();
            return \Response::json(array('status' => '200', 'message' => 'Report thành công!'));
        }
        return \Response::json(array('status' => '404', 'message' => 'Comment không tồn tại!'));
    }

    public function storeReply(Request $request)
    {
        $comment = CommentCourse::find($request->parent_id);
        if ($comment) {
            if(Auth::user()->isAdmin()){
                $commentCourse = new CommentCourse;
                $commentCourse->content = $request->content;
                $commentCourse->user_role_id = Auth::user()->userRolesAdmin()->id;
                $commentCourse->course_id = $comment->course_id;
                $commentCourse->parent_id = (int) $request->parent_id;
                $commentCourse->score = 0;
                $commentCourse->state = 0;
                $commentCourse->save();
                
                return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentCourse' => fractal($commentCourse, new CommentCourseTransformer())->toArray()));
            }
            $commentCourse = new CommentCourse;
            $commentCourse->content = $request->content;
            $commentCourse->user_role_id = Auth::user()->userRolesStudent()->id;
            $commentCourse->course_id = $comment->course_id;
            $commentCourse->parent_id = (int) $request->parent_id;
            $commentCourse->score = 0;
            $commentCourse->state = 0;
            $commentCourse->save();

            return \Response::json(array('status' => '200', 'message' => 'Cập nhật thông tin thành công!', 'commentCourse' => fractal($commentCourse, new CommentCourseTransformer())->toArray()));
        }
        return \Response::json(array('status' => '404', 'message' => 'Khóa học không tồn tại!'));
    }

    public function insertStarTeacher(Request $request)
    {
        $ratingTeacher = new RatingTeacher;
        $ratingTeacher->user_id = Auth::id();
        $ratingTeacher->teacher_id = $request->teacher_id;
        $ratingTeacher->score = $request->score;
        $ratingTeacher->save();

        $teacher = Teacher::where('user_role_id', $request->teacher_id)->first();
        $teacher->rating_count += $request->score;
        $teacher->vote_count += 1;
        $teacher->rating_score = number_format($teacher->rating_count/$teacher->vote_count, 1, '.' , '.');
        $teacher->save();
        return \Response::json(array('status' => '200', 'message' => 'Review success!'));
    }

    public function updateStarTeacher(Request $request)
    {
        $ratingTeacher = RatingTeacher::where('teacher_id', $request->teacher_id)->where('user_id', Auth::id())->first();
        $rating_count = $request->score - $ratingTeacher->score;
        $ratingTeacher->score = $request->score;
        $ratingTeacher->save();

        $teacher = Teacher::where('user_role_id', $request->teacher_id)->first();
        $teacher->rating_count += $rating_count;
        // echo $teacher->rating_count.'--'.$teacher->vote_count;die;
        $teacher->rating_score = number_format($teacher->rating_count/$teacher->vote_count, 1, '.' , '.');
        $teacher->save();
        return \Response::json(array('status' => '200', 'message' => 'Review updated success!'));
    }
}
