<?php
namespace App\Http\Controllers\Frontends;

use App\Category;
use App\Coupon;
use App\Course;
use App\Helper\Helper;
use App\Order;
use App\RatingCourse;
use App\RatingTeacher;
use App\Tag;
use App\Teacher;
use App\User;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function comingSoon()
    {
        return view('frontends.coming-soon');
    }

    public function listCourse(Request $request)
    {
        $type = trim($request->get('type'));
        if ($type == 'best-seller') {
            $list_course = Course::where('status', 1)->orderBy('sale_count', 'desc')->paginate(16);
            $title = 'Best seller';
        } elseif ($type == 'new') {
            $list_course = Course::where('status', 1)->orderBy('id', 'desc')->paginate(16);
            $title = 'New';
        } elseif ($type == 'trendding') {
            $list_course = Course::where('status', 1)->where('featured', 1)->orderBy('featured_index', 'asc')->paginate(16);
            $title = 'Trendding';
        }

        return view('frontends.list-course-by-type', compact('list_course', 'title'));
    }

    public function home()
    {
        $feature_category = Category::withCount('courses')->where('parent_id', '>', 0)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
        // trending = feature courses
        $feature_course = Course::where('status', 1)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::where('status', 1)->orderBy('sale_count', 'desc')->limit(8)->get();
        $new_course = Course::where('status', 1)->orderBy('id', 'desc')->limit(8)->get();
        $popular_teacher = Teacher::getTeacherBestVote();
        return view('frontends.home', compact('feature_category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $results = [];

        if ($keyword != '') {
            $keyword = trim($request->get('keyword'));
            $arr_course_id = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
                ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
                ->join('user_courses', 'user_courses.user_role_id', '=', 'user_roles.id')
                ->join('courses', 'courses.id', '=', 'user_courses.course_id')
                ->select('user_courses.course_id')
                ->where('user_roles.role_id', \Config::get('app.teacher'))
                ->where('teachers.status', 1)
                ->where('courses.status', 1)
                ->where('users.name', 'LIKE', "%$keyword%")
                ->pluck('course_id');
            $results = Course::where('status', 1)->where('name', 'LIKE', "%$keyword%")->orwhereIn('id', $arr_course_id)->paginate(8);
        }

        return view('frontends.search', compact('results'));
    }

    public function showCategory($cat)
    {
        $cat_id = Category::where('slug', $cat)->value('id');

        if ($cat_id) {
            $tags = Tag::where('category_id', $cat_id)->get();
            $feature_course = Course::where('status', 1)->where('category_id', $cat_id)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
            $best_seller_course = Course::where('status', 1)->where('category_id', $cat_id)->orderBy('sale_count', 'desc')->limit(8)->get();
            $new_course = Course::where('status', 1)->where('category_id', $cat_id)->orderBy('id', 'desc')->limit(8)->get();
            $popular_teacher = Teacher::getTeacherBestVote();
            return view('frontends.category', compact('category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher', 'tags'));
        }

        return abort(404);
    }

    public function showTag($tag)
    {
        $tag = Tag::where('slug', $tag)->first();
        if ($tag) {
            return view('frontends.tag', compact('tag'));
        }
        return abort(404);
    }

    public function showCourse($course)
    {
        
        $course = Course::where('slug', $course)->first();

        if ($course) {
            $course->view_count = $course->view_count + 1;
            $course->save();
        }

        if (\Auth::check()) {
            if ($course) {
                $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                $related_course = Course::where('category_id', $course->category_id)->where('id','!=',$course->id)->limit(4)->get();
                $info_course = Course::find($course->id);
                // dd($info_course->comments[0]->likeCheckUser());
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit', 'ratingCourse'));
            }
        } else {
            if ($course) {
                $related_course = Course::where('category_id', $course->category_id)->where('id','!=',$course->id)->limit(4)->get();
                $info_course = Course::find($course->id);
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit'));
            }
        }
        return abort(404);
    }

    public function showTeacher($id_teacher)
    {
        $teacher = Teacher::find($id_teacher);
        // dd($teacher->user_role_id);
        if ($teacher) {
            if(\Auth::check()){
                $ratingTeacher = RatingTeacher::where('teacher_id', $id_teacher)->where('user_id', \Auth::id())->first();
            }else{
                $ratingTeacher = RatingTeacher::where('teacher_id', $id_teacher)->first();
            }
            $feature_category = Category::where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
            $info_teacher = $teacher;
            $feature_course = $teacher->userRole()->first()->userCoursesByFeature();
            $best_seller_course = $teacher->userRole()->first()->userCoursesByTrendding();
            $new_course = $teacher->userRole()->first()->userCoursesByNew();
            return view('frontends.detail-teacher', compact('info_teacher', 'feature_category', 'feature_course', 'best_seller_course', 'new_course', 'ratingTeacher'));
        }
        return abort(404);
    }

    public function memberCard()
    {
        return view('frontends.member-card');
    }

    public function courseCategory()
    {
        $category = Category::get();
        $feature_category = Category::where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
        $feature_course = Course::where('status', 1)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::where('status', 1)->orderBy('sale_count', 'desc')->limit(8)->get();
        $new_course = Course::where('status', 1)->orderBy('id', 'desc')->limit(8)->get();
        $popular_teacher = Teacher::get();

        return view('frontends.course-category', compact('category', 'feature_category', 'feature_course', 'best_seller_course', 'new_course'));
    }

    public function detailTeacher()
    {
        return view('frontends.detail-teacher');
    }

    public function courseLearning($course)
    {
        $course = Course::where('status', 1)->where('slug', $course)->first();
        if (\Auth::check()) {
            if ($course) {
                $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                // $related_courses = Course::where('status', 1)->where('category_id', $course->category_id)->limit(4)->get();
                $related_courses = Course::where('status', 1)->where('category_id', $course->category_id)->where('id','!=',$course->id)->limit(4)->get();
                $info_course = Course::where('status', 1)->find($course->id);
                $user_role_course_instance = Helper::getUserRoleOfCourse($course->id);

                $lecturer_array = $info_course->Lecturers();
                $lecturers = [];
                foreach ($lecturer_array as $lecturer_obj) {
                    // array_push($lecturers, User::find($))
                }

                return view('frontends.course-learning', compact('related_courses', 'info_course', 'unit', 'ratingCourse', 'user_role_course_instance'));
            }
        } else {
            if ($course) {
                $related_courses = Course::where('status', 1)->where('category_id', $course->category_id)->where('id','!=',$course->id)->limit(4)->get();
                $info_course = Course::where('status', 1)->find($course->id);
                return view('frontends.course-learning', compact('related_courses', 'info_course', 'unit'));
            }
        }
        return abort(404);

    }

    public function courseDetail()
    {
        return view('frontends.course-detail');
    }

    public function studentProfile()
    {
        return view('frontends.student-profile');
    }

    public function courseList()
    {
        return view('frontends.course-list');
    }

    public function logout()
    {
        Auth::logout();
    }

    public function cart()
    {
        return view('frontends.cart');
    }

    public function checkCoupon(Request $request)
    {
        $coupon = Coupon::where('name', $request->coupon)->first();
        if ($coupon) {
            return \Response::json(array('status' => '200', 'coupon' => $coupon));
        }
        return \Response::json(array('status' => '404', 'message' => 'Coupon không tồn tại!'));
    }

    public function checkout(Request $request)
    {
        if (Auth::check()) {
            $current_user = Auth::user();
            $user_role_id = $current_user->userRolesStudent();
            $items = $request->items;
            if ($items) {
                // check coins
                $total_price = 0;
                foreach ($items as $item) {
                    if ($item['id']) {
                        $course = Course::find($item['id']);
                        if ($course) {
                            $total_price += $course->price;
                        }
                    }
                }

                if ($total_price > Auth::user()->coins) {
                    return \Response::json(array('status' => '204', 'message' => 'Your balance is not enough'));
                }

                // check coupon
                $coupon = null;
                if ($request->coupon) {
                    $coupon = Coupon::where('name', $request->coupon)->first();
                }

                $order = new Order;
                $order->payment_id = 1; // 1 = ck
                $order->user_id = $user_role_id->id;
                $order->status = 1; // 1 = ok, 2 = pending, 0 = cancel
                $order->total_price = 0;
                $order->coupon = '';
                $order->save();

                $bought = [];
                if (strlen($current_user->bought) > 0) {
                    $bought = \json_decode($current_user->bought);
                }

                foreach ($items as $item) {
                    if ($item['id']) {
                        $course = Course::find($item['id']);
                        if ($course) {
                            $bought[] = $item['id'];
                            $video_count = $course->video_count;
                            $first_video_index = 1;
                            $first_video_id = $course->units[0]->videos[0]->id;
                            $user_course_videos = [];
                            for ($i = 0; $i < $video_count; $i++) {
                                array_push($user_course_videos, 0);
                            }
                            $videoJson = new VideoJson;
                            $videoJson->videos = $user_course_videos;
                            $videoJson->learning = 1;
                            $videoJson->learning_id = $first_video_id;

                            $videoJson = json_encode($videoJson);

                            $course->userRoles()->attach($user_role_id->id, ['videos' => $videoJson]);
                            $order->courses()->attach($item['id']);
                        }
                    }
                }
                if ($coupon) {
                    $order->total_price = $total_price * (100 - $coupon->value) / 100;
                    $order->coupon = $coupon->name;
                } else {
                    $order->total_price = $total_price;
                    $order->coupon = '';
                }
                $order->save();
                $current_user->bought = \json_encode($bought);
                $current_user->coins = $current_user->coins - $total_price;
                $current_user->save();
                return \Response::json(array('status' => '201', 'message' => 'Order has been created'));
            }
            return \Response::json(array('status' => '204', 'message' => 'Order has not been created'));
        } else {
            return \Response::json(array('status' => '401', 'message' => 'Unauthorized'));
        }
    }

    public function showMethodSelector(Request $request)
    {
        $user = Auth::user();
        $user_balance = $user->coins;

        return view('frontends.payment-methods', compact('user_balance'))->render();
    }

    public function getFinalPrice(Request $request)
    {
        $coupon_code = '';
        if ($request->coupon_code) {
            $coupon_code = $request->coupon_code;
            $coupon = Coupon::where('name', $coupon_code)->first();
            $coupon_value = $coupon->value;
        }
        $items = $request->items;

        $final_price = 0;

        foreach ($items as $key => $item) {
            $item_id = $item['id'];
            $course = Course::find($item_id);
            if (!isset($course)) {
                return response()->json([
                    'status' => '404',
                    'message' => 'Cannot find the course has id = ' . $item_id,
                ]);
            }
            $final_price += $course->price;
        }
        if (isset($coupon)) {
            $final_price = $final_price - ($final_price * $coupon_value / 100);

        }
        return response()->json([
            'status' => '200',
            'message' => 'Get final price successfully!',
            'final_price' => $final_price,
            'applied_coupon' => $coupon_code,
        ]);
    }

    public function saveFileAjax(Request $request)
    {
        if ($request->hasFile('file-mp4-upload-off')) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $file = $request->file('file-mp4-upload-off');
            $temp = explode(".", $file->getClientOriginalName());
            $filenamejoin = '';
            for ($i = 0; $i < count($temp) - 1; $i++) {
                $filenamejoin .= $temp[$i] . '.';
            }

            $destinationPath = 'uploads/videos/';
            $filename = time() . '_' . csrf_token();
            $_SESSION[$filename] = rtrim($filenamejoin, ".");
            $fileExt = $temp[count($temp) - 1];
            $fileExt = strtolower($fileExt);
            if (file_exists($destinationPath . $filename . '.' . $fileExt)) {
                unlink($destinationPath . $filename . '.' . $fileExt);
            }
            $file->move($destinationPath, $filename . '.' . $fileExt);
            echo $filename;
        }
    }

    public function duration(Request $request)
    {
        if (!file_exists(public_path("/uploads/videos/") . $request->fileName . '.' . $request->input)) {
            if (file_exists(public_path("/uploads/videos/") . $request->fileName . '.qt')) {
                $request->input = 'qt';
            } else if (file_exists(public_path("/uploads/videos/") . $request->fileName . '.asf')) {
                $request->input = 'asf';
            }
        }

        $command = config('config.path_ffprobe_exe') . ' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ' . public_path("/uploads/videos/") . $request->fileName . '.' . $request->input . ' 2>&1';
        $input = public_path('/uploads/videos/') . $request->fileName . '.' . $request->input;
        exec($command, $output, $return);
        if (!$return) {
            echo json_encode(array('status' => 200, 'duration' => exec($command, $output, $return)));
        } else {
            echo json_encode(array('status' => 404));
        }

    }

    public function naptien(){
        $users = User::get();
        foreach($users as $user){
            $user->coins += 1000000;
            $user->save();
        }
        echo "Đã nạp cho mỗi người 1 củ nhé!";
    }
}

class VideoJson
{
    public $videos, $learning, $learning_id;
}
