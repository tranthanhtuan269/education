<?php
namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use App\Helper\Helper;
use App\RatingCourse;
use App\Category;
use App\Teacher;
use App\Course;
use App\Coupon;
use App\Order;
use App\User;
use App\Tag;
use Auth;

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
            $list_course = Course::orderBy('sale_count', 'desc')->paginate(16);
            $title = 'Best seller';
        } elseif ($type == 'new') {
            $list_course = Course::orderBy('id', 'desc')->paginate(16);
            $title = 'New';
        } elseif ($type == 'trendding') {
            $list_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->paginate(16);
            $title = 'Trendding';
        }

        return view('frontends.list-course-by-type', compact('list_course', 'title'));
    }

    public function home()
    {
        $feature_category = Category::withCount('courses')->where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
        // trending = feature courses
        $feature_course = Course::getCourseNotLearning()->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::getCourseNotLearning()->orderBy('sale_count', 'desc')->limit(8)->get();
        $new_course = Course::getCourseNotLearning()->orderBy('id', 'desc')->limit(8)->get();
        $popular_teacher = Teacher::getTeacherBestVote();
        //dd($popular_teacher->userRole);
        return view('frontends.home', compact('feature_category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $results = [];
        if ($keyword != '') {
            $keyword = trim($request->get('keyword'));
            $results = Course::getCourseNotLearning()->where('name', 'LIKE', "%$keyword%")->paginate(8);
        }
        return view('frontends.search', compact('results'));
    }

    public function showCategory($cat)
    {
        $cat_id = Category::where('slug', $cat)->value('id');
        if ($cat_id) {
            $tags = Tag::where('category_id', $cat_id)->get();
            $feature_course = Course::getCourseNotLearning()->where('category_id', $cat_id)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
            $best_seller_course = Course::getCourseNotLearning()->where('category_id', $cat_id)->orderBy('sale_count', 'desc')->limit(8)->get();
            $new_course = Course::getCourseNotLearning()->where('category_id', $cat_id)->orderBy('id', 'desc')->limit(8)->get();
            $popular_teacher = Teacher::getTeacherBestVote();
            return view('frontends.category', compact('category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher', 'tags'));
        }
        return abort(404);
    }

    public function showCourse($course)
    {
        $course = Course::where('slug', $course)->first();
        if (\Auth::check()) {
            if ($course) {
                $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                $related_course = Course::getCourseNotLearning()->where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                // dd($info_course->comments[0]->likeCheckUser());
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit', 'ratingCourse'));
            }
        } else {
            if ($course) {
                $related_course = Course::getCourseNotLearning()->where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit'));
            }
        }
        return abort(404);
    }

    public function showTeacher($id_teacher)
    {
        $user = User::find($id_teacher);
        if($user){
            $info_teacher = $user->userRolesTeacher()->teacher;
            $feature_course = $user->userRolesTeacher()->userCoursesByFeature();
            $best_seller_course = $user->userRolesTeacher()->userCoursesByTrendding();
            $new_course = $user->userRolesTeacher()->userCoursesByNew();
            return view('frontends.detail-teacher', compact('info_teacher', 'feature_category', 'feature_course', 'best_seller_course', 'new_course'));
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
        $feature_course = Course::getCourseNotLearning()->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::getCourseNotLearning()->orderBy('sale_count', 'desc')->limit(8)->get();
        $new_course = Course::getCourseNotLearning()->orderBy('id', 'desc')->limit(8)->get();
        $popular_teacher = Teacher::get();

        return view('frontends.course-category', compact('category', 'feature_category', 'feature_course', 'best_seller_course', 'new_course'));
    }

    public function detailTeacher()
    {
        return view('frontends.detail-teacher');
    }

    public function courseLearning($course)
    {
        $course = Course::where('slug', $course)->first();
        if (\Auth::check()) {
            if ($course) {
                $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                $related_courses = Course::getCourseNotLearning()->where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                $user_role_course_instance = Helper::getUserRoleOfCourse($course->id);

                $lecturer_array = $info_course->Lecturers();
                $lecturers = [];
                foreach ($lecturer_array as $lecturer_obj) {
                    // array_push($lecturers, User::find($))
                }

                return view('frontends.course-learning', compact('related_courses', 'info_course', 'unit', 'ratingCourse', 'user_role_course_instance'));
            }
        }else{
            if($course){
                $related_courses = Course::getCourseNotLearning()->where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
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

    public function cart(){
        return view('frontends.cart');
    }

    public function checkCoupon(Request $request){
        $coupon = Coupon::where('name', $request->coupon)->first();
        if($coupon){
            return \Response::json(array('status' => '200', 'coupon' => $coupon));
        }
        return \Response::json(array('status' => '404', 'message' => 'Coupon không tồn tại!'));
    }

    public function checkout(Request $request){
        if(Auth::check()){
            $user_role_id = Auth::user()->userRolesStudent();
            $items = $request->items;
            if($items){
                // check coupon
                $coupon = null;
                if($request->coupon){
                    $coupon = Coupon::where('name', $request->coupon)->first();
                }

                $order = new Order;
                $order->payment_id = 1; // 1 = ck
                $order->user_id = $user_role_id->id;
                $order->status = 1; // 1 = ok, 2 = pending, 0 = cancel
                $order->total_price = 0;
                $order->coupon = '';
                $order->save();

                $total_price = 0;
                foreach($items as $item){
                    if($item['id']){
                        $course = Course::find($item['id']);
                        if($course){
                            $course->userRoles()->attach($user_role_id->id);
                            $order->courses()->attach($item['id']);
                            $total_price+= $course->price;
                        }
                    }
                }
                if($coupon){
                    $order->total_price = $total_price * (100 - $coupon->value) / 100;
                    $order->coupon = $coupon->name;
                }else{
                    $order->total_price = $total_price;
                    $order->coupon = '';
                }
                $order->save();
                return \Response::json(array('status' => '201', 'message' => 'Order has been created'));
            }
            return \Response::json(array('status' => '204', 'message' => 'Order has not been created'));
        }else{
            return \Response::json(array('status' => '401', 'message' => 'Unauthorized'));
        }
    }
}
