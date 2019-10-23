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
use App\Unit;
use App\Email;
use App\Video;
use App\Setting;
use App\Mail\OrderCompleted;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\UserRole;
use DB;
use App\Document;
use Config;
use App\VideoJson;

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
            $title = 'Các khoá học bán chạy';
            $list_course = Course::listCourseSpecial(1)->paginate(16);
        } elseif ($type == 'new') {
            $list_course = Course::listCourseSpecial(2)->paginate(16);
            $title = 'Các khóa học mới nhất';
        } elseif ($type == 'trendding') {
            $list_course = Course::listCourseSpecial(3)->paginate(16);
            $title = 'Các khóa học thịnh hành';
        }

        return view('frontends.list-course-by-type', compact('list_course', 'title'));
    }

    public function home()
    {
        $video = new VideoJson;

        $feature_category = Category::getCoursesOfCategory()->get();

        // Duong NT// feature courses
        $percent_feature_course = Setting::where('name', 'percent_feature_course')->first()->value;
        $feature_course = Course::where('status', 1)
                                ->orderBy('featured', 'desc')
                                ->orderBy('featured_index', 'asc')
                                ->get(['id', 'name', 'slug', 'image', 'price', 'real_price', 'featured_index', 'featured']);
        $feature_course = $feature_course->filter(function ($value, $key) use ($percent_feature_course) {
            $percent = null;
            if($value->price < $value->real_price){
                $percent = intval(100 - (($value->price/$value->real_price)*100));
                if($percent >= intval($percent_feature_course)){
                    $value->setAttribute('discount_percent', $percent); // thêm trường discount_percent
                }
            }else{
                $percent = 0;
            }
            return ($percent >= intval($percent_feature_course)) || $value->featured == 1 ;
        })->sortByDesc('featured')
        ->values(); //reindex the collection
        $feature_course_count = $feature_course->count();
        $remainder = $feature_course_count%3;
        if($remainder > 0){
            $feature_course_limit = $feature_course_count - $remainder;
        }else{
            $feature_course_limit = $feature_course_count;
        }
        $feature_course = $feature_course->take($feature_course_limit);
        //end finding feature courses

        // $best_seller_course = Course::where('status', 1)->orderBy('sale_count', 'desc')->limit(8)->get();listCourseHome
        $best_seller_course = Course::listCourseHome()->orderBy('sale_count', 'desc')->limit(8)->get();

        $new_course = Course::listCourseHome()->orderBy('id', 'desc')->limit(8)->get();

        $limitDate = \Carbon\Carbon::now()->subDays(15);
        $sql = "SELECT course_id, count(course_id) FROM orders
        JOIN order_details ON orders.id = order_details.order_id
        WHERE created_at > '" . $limitDate->toDateTimeString() ."'
        group by course_id
        ORDER BY count(course_id) desc;";

        $results = DB::select($sql);
        $course_id_arr = [];
        foreach ($results as $key => $result) {
            $course_id_arr[] = $result->course_id;
        }
        $trending_courses = \App\Course::whereIn('id', $course_id_arr)->where('status', 1)->get()->take(8);

        $popular_teacher = Teacher::getFeatureTeacher();
        return view('frontends.home', compact('feature_category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher', 'trending_courses' ));
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
                ->where(function ($query) use ($keyword) {
                    $query->orWhere('users.name', 'LIKE', "%$keyword%");
                    $query->orwhere('courses.name', 'LIKE', "%$keyword%");
                })
                ->pluck('course_id');
            $results = Course::whereIn('id', $arr_course_id)->paginate(16);
        }

        return view('frontends.search', compact('results'));
    }

    public function listCourseCategory(Request $request)
    {
        $type = trim($request->get('type'));
        $cat_id = $request->cat_id;
        $category = Category::find($cat_id);
        $cat_name = $category->name;
        $cat_icon = $category->icon;
        if ($type == 'best-seller') {
            $title = 'Các khoá học bán chạy';
            $list_course = Course::listCourseCategory($cat_id)->orderBy('sale_count', 'desc')->paginate(16);
        } elseif ($type == 'new') {
            $list_course = Course::listCourseCategory($cat_id)->orderBy('id', 'desc')->paginate(16);
            $title = 'Các khóa học mới nhất';
        } elseif ($type == 'trendding') {
            $limitDate = \Carbon\Carbon::now()->subDays(15);
            $sql = "SELECT course_id, count(course_id) FROM orders JOIN order_details ON orders.id = order_details.order_id WHERE created_at > '" . $limitDate->toDateTimeString() ."' group by course_id ORDER BY count(course_id) desc LIMIT 8;";
            $results = DB::select($sql);
            foreach ($results as $key => $result) {
                $course_id_arr[] = $result->course_id;
            }
            $list_course = \App\Course::whereIn('id', $course_id_arr)->where('category_id', $cat_id)->get();
            // $list_course = Course::listCourseSpecial(3)->paginate(16);
            $title = 'Các khóa học thịnh hành';
        }

        return view('frontends.list-course-category-by-type', compact('list_course', 'title', 'cat_name', 'cat_icon'));
    }

    public function showCategory($cat)
    {
        $cat_id = Category::where('slug', $cat)->value('id');

        if ($cat_id) {

            $category = Category::where('slug', $cat)->first();

            $tags = Tag::where('category_id', $cat_id)->get();

            // $feature_course = Course::where('status', 1)->where('category_id', $cat_id)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
            // $feature_course = Course::listCourseCategory(1)->limit(8)->get();

            // $best_seller_course = Course::where('status', 1)->where('category_id', $cat_id)->orderBy('sale_count', 'desc')->limit(8)->get();
            $best_seller_course = Course::listCourseCategory($cat_id)->orderBy('sale_count', 'desc')->limit(8)->get();
            // $best_seller_course = Course::listCourseCategory(3);

            // $new_course = Course::where('status', 1)->where('category_id', $cat_id)->orderBy('id', 'desc')->limit(8)->get();
            $new_course = Course::listCourseCategory($cat_id)->orderBy('id', 'desc')->limit(8)->get();

            $limitDate = \Carbon\Carbon::now()->subDays(15);
            $sql = "SELECT course_id, count(course_id) FROM orders JOIN order_details ON orders.id = order_details.order_id WHERE created_at > '" . $limitDate->toDateTimeString() ."' group by course_id ORDER BY count(course_id) desc LIMIT 8;";
            $results = DB::select($sql);
            foreach ($results as $key => $result) {
                $course_id_arr[] = $result->course_id;
            }
            $trending_courses = \App\Course::whereIn('id', $course_id_arr)->where('category_id', $cat_id)->get();

            // $popular_teacher = Teacher::getTeacherBestVote();

            $popular_teacher = Teacher::getTeacherBestVote($cat_id);


            // $filtered_teachers = $popular_teacher->filter(function ($teacher, $key) use ($cat_id){
            //     $courses = $teacher->courses->where('category_id', $cat_id);

            //     return $courses->cate;
            // });
            return view('frontends.category', compact('category', 'feature_course', 'best_seller_course', 'new_course', 'trending_courses', 'popular_teacher', 'tags' ));
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

    public function showCourse($id,$slug)
    {
        $course = Course::where('id', $id)->first();
        // dd($course);
        if($course){
            if($course->status == 1){
                if ($course) {
                    $course->view_count = $course->view_count + 1;
                    $course->save();
                }

                if (\Auth::check()) {
                    if ($course) {
                        $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                        $related_course = Course::listCourseCategoryNotMe($course->category_id, $course->id)->limit(4)->get();
                        $info_course = Course::find($course->id);

                        $units = Unit::where('course_id', $course->id)->get();
                        $document_count = 0;
                        foreach( $units as $unit ){
                            if( $unit ){
                                $videos = Video::where('unit_id', $unit->id)->get();
                                foreach( $videos as $video ){
                                    if( $video ){
                                        $document_count += Document::where('video_id', $video->id)->count();
                                    }
                                }
                            }
                        }

                        return view('frontends.course-detail', compact('related_course', 'info_course', 'ratingCourse', 'document_count'));
                    }
                } else {
                    if ($course) {
                        $related_course = Course::listCourseCategoryNotMe($course->category_id, $course->id)->limit(4)->get();
                        $info_course = Course::find($course->id);

                        $units = Unit::where('course_id', $course->id)->get();
                        $document_count = 0;
                        foreach( $units as $unit ){
                            if( $unit ){
                                $videos = Video::where('unit_id', $unit->id)->get();
                                foreach( $videos as $video ){
                                    if( $video ){
                                        $document_count += Document::where('video_id', $video->id)->count();
                                    }
                                }
                            }
                        }

                        return view('frontends.course-detail', compact('related_course', 'info_course', 'document_count'));
                    }
                }
            }else{
                if( (\Auth::check() && \Auth::user()->isAdmin()) || (\Auth::check() && Auth::user()->userRolesTeacher()->userCoursesByTeacher()->where('id', $course->id)->first() != null )){
                    $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                    $related_course = Course::listCourseCategoryNotMe($course->category_id, $course->id)->limit(4)->get();
                    $info_course = Course::find($course->id);

                    $units = Unit::where('course_id', $course->id)->get();
                    $document_count = 0;
                    foreach( $units as $unit ){
                        if( $unit ){
                            $videos = Video::where('unit_id', $unit->id)->get();
                            foreach( $videos as $video ){
                                if( $video ){
                                    $document_count += Document::where('video_id', $video->id)->count();
                                }
                            }
                        }
                    }

                    return view('frontends.course-detail', compact('related_course', 'info_course', 'ratingCourse', 'document_count'));
                }else{
                    return Redirect('/');
                }
            }
        }else{
            return abort(404);
        }
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
            // $feature_course = $teacher->userRole()->first()->userCoursesByFeature();
            // $best_seller_course = $teacher->userRole()->first()->userCoursesByTrendding();
            // $new_course = $teacher->userRole()->first()->userCoursesByNew();
            $courses_of_teacher = $teacher->userRole()->first()->userCoursesByTeacher()->where('status', 1);
            // $category_first_course = $courses_of_teacher->first()->category_id;
            // $course_of_category = Course::where('category_id', $courses_of_teacher->first()->category_id)->get();
            return view('frontends.detail-teacher', compact('info_teacher', 'feature_category', 'ratingTeacher', 'courses_of_teacher'));
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

        if(isset($coupon->course_id)){
            $expired = strtotime($coupon->expired);
            $today = strtotime(date("Y-m-d"));
            if($expired < $today){
                return \Response::json(array('status' => '403'));
            }
            $str_course_id = $coupon->course_id;
            $arr_course_id = explode(",",$str_course_id);

            foreach ($arr_course_id as $key => $course_id) {
                if( $request->course_id == $course_id ){
                    return \Response::json(array('status' => '200', 'coupon' => $coupon, 'coupon_value' => $coupon->value));
                }
            }
        }
        return \Response::json(array('status' => '404', 'message' => 'Coupon không tồn tại!'));
    }

    // public function checkout(Request $request)
    // {
    //     if (Auth::check()) {
    //         $current_user = Auth::user();
    //         $user_role_id = $current_user->userRolesStudent();
    //         $items = $request->items;
    //         if ($items) {
    //             $coupon = null;
    //             $coupon_value;
    //             $coupon_name;

    //             $cart = \json_decode($request->cart, true);

    //             $total_price = 0;

    //             $order = new Order;
    //             $order->payment_id = 1; // 1 = ck
    //             $order->user_id = $user_role_id->id;
    //             $order->status = 1; // 1 = ok, 2 = pending, 0 = cancel
    //             $order->total_price = 0;
    //             $order->coupon = '';
    //             $order->save();

    //             foreach ($items as $key => $item) {
    //                 if ($item['id']) {
    //                     $coupon = Coupon::where('name', $item["coupon_code"])->where('course_id', $item["id"])->first();
    //                     $course = Course::find($item['id']);
    //                     if ($course) {
    //                         if($coupon){
    //                             $total_price =  $total_price + $course->price * (100 - $coupon->value) / 100;
    //                         }else{
    //                             $total_price += $course->price;
    //                         }

    //                         $bought[] = $item['id']; //Them vao trường đã mua của user TuanTT
    //                         $video_count = $course->video_count;
    //                         $units = $course->units;
    //                         $first_video_index = 1;
    //                         $first_video_id = $course->units[0]->videos[0]->id;
    //                         $user_course_videos = [];

    //                         //DuongNT - Tạo array video đã xem
    //                         foreach ($units as $key => $unit) {
    //                             if($unit->video_count > 0){
    //                                 $unit_arr = [];
    //                                 for ($k=0; $k < $unit->video_count; $k++) {
    //                                     array_push($unit_arr, 0);
    //                                 }
    //                                 array_push($user_course_videos, $unit_arr);
    //                             }
    //                         }
    //                         $videoJson = new VideoJson;
    //                         $videoJson->videos = $user_course_videos;
    //                         $videoJson->learning = 1;
    //                         $videoJson->learning_id = $first_video_id;

    //                         $videoJson = json_encode($videoJson);

    //                         $course->userRoles()->attach($user_role_id->id, ['videos' => $videoJson]);
    //                         $order->courses()->attach($item['id']);
    //                     }

    //                     // lưu vào bảng teacher của mỗi course để tăng số lượng học viên cho mỗi teacher
    //                     $teacher = $course->Lecturers()->first()->teacher;
    //                     $teacher->student_count += 1;
    //                     $teacher->save();
    //                 }
    //             }

    //             // dd($total_price);

    //             $bought = [];
    //             if (strlen($current_user->bought) > 0) {
    //                 $bought = \json_decode($current_user->bought);
    //             }
    //             if ($coupon) {
    //                 // $order->total_price = $total_price * (100 - $coupon->value) / 100;
    //                 $order->total_price = $total_price;
    //                 $order->coupon = $coupon->name;
    //             } else {
    //                 $order->total_price = $total_price;
    //                 $order->coupon = '';
    //             }
    //             $order->save();
    //             $current_user->bought = \json_encode($bought);
    //             $current_user->coins = $current_user->coins - $total_price;
    //             $current_user->save();


    //             return \Response::json(array('status' => '201', 'message' => 'Order has been created'));
    //         }
    //         return \Response::json(array('status' => '204', 'message' => 'Order has not been created'));
    //     } else {
    //         return \Response::json(array('status' => '401', 'message' => 'Unauthorized'));
    //     }
    // }

    public function checkout(Request $request)
    {
        if (Auth::check()) {
            $current_user = Auth::user();
            $coins_user = Auth::user()->coins;
            $user_role_id = $current_user->userRolesStudent();
            $items = $request->items;
            $check_coin = false;
            if ($items) {
                // check coins
                $total_price = 0;
                foreach ($items as $item) {
                    if ($item['id']) {
                        $coupon = Coupon::where('name', $item["coupon_code"])->first();
                        $course = Course::find($item['id']);
                        if ($course) {
                            if($coupon){
                                $expired = strtotime($coupon->expired);
                                $today = strtotime(date("Y-m-d"));
                                $coupon_value = $coupon->value;
                                if($expired >= $today){
                                    $total_price =  $total_price + $course->price * (100 - $coupon->value) / 100;
                                }
                            }else{
                                $total_price += $course->price;
                            }

                            if( $coins_user >= $total_price ){
                                $check_coin = true;
                            }else{
                                return \Response::json(array('status' => '204', 'message' => 'Order has not been created'));
                            }
                        }
                    }
                }
                // if ($total_price > Auth::user()->coins) {
                //     return \Response::json(array('status' => '204', 'message' => 'Your balance is not enough'));
                // }
                // check coupon
                // $coupon = null;
                // if ($request->coupon) {
                //     $coupon = Coupon::where('name', $request->coupon)->first();
                // }

                // $order = new Order;
                // $order->payment_id = 1; // 1 = ck
                // $order->user_id = $user_role_id->id;
                // $order->status = 1; // 1 = ok, 2 = pending, 0 = cancel
                // $order->total_price = 0;
                // $order->coupon = '';
                // $order->save();
                if( $check_coin == true ){
                    $coupon = null;
                    $coupon_value = null;
                    $coupon_name = null;

                    $cart = \json_decode($request->cart, true);

                    $total_price = 0;

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

                    foreach ($items as $key => $item) {
                        if ($item['id']) {
                            $coupon = Coupon::where('name', $item["coupon_code"])->first();
                            $course = Course::find($item['id']);
                            $coupon_value = 0;
                            if ($course) {
                                if($coupon){
                                    $expired = strtotime($coupon->expired);
                                    $today = strtotime(date("Y-m-d"));
                                    $coupon_value = $coupon->value;
                                    if($expired >= $today){
                                        $total_price =  $total_price + $course->price * (100 - $coupon->value) / 100;
                                    }
                                }else{
                                    $total_price += $course->price;
                                }
                                
                                $bought[] = $item['id']; //Them vao trường đã mua của user TuanTT
                                
                                // dd($coupon_value);
                                $course->userRoles()->attach($user_role_id->id, ['videos' => Helper::buildJsonForCheckout($course->id)]);
                                $order->courses()->attach($item['id'], ['coupon'=>$item["coupon_code"],'percent'=>$coupon_value]);
                            }
                            
                            // lưu vào bảng teacher của mỗi course để tăng số lượng học viên cho mỗi teacher
                            $teacher = $course->Lecturers()->first()->teacher;
                            if($teacher){
                                $teacher->student_count += 1;
                                $teacher->save();
                            }

                            $course2 = Course::find($item['id']);
                            $course2->student_count += 1;
                            $course2->sale_count += 1;
                            $course2->save();
                        }
                    }

                    // if ($coupon) {
                    //     $order->total_price = $total_price * (100 - $coupon->value) / 100;
                    //     $order->coupon = $coupon->name;
                    // } else {
                    //     $order->total_price = $total_price;
                    //     $order->coupon = '';
                    // }
                    // $order->save();
                    // $current_user->bought = \json_encode($bought);
                    // $current_user->coins = $current_user->coins - $total_price;
                    // $current_user->save();

                    if ($coupon) {
                        // $order->total_price = $total_price * (100 - $coupon->value) / 100;
                        $order->total_price = $total_price;
                        $order->coupon = $coupon->name;
                    } else {
                        $order->total_price = $total_price;
                        $order->coupon = '';
                    }
                    Mail::to($current_user)->queue(new OrderCompleted($order, $current_user));
                    // dd($order->courses[0]->pivot->coupon);
                    
                    $order_content = [];
                    foreach ( $order->courses as $course ){
                        $orderCourseObj = new OrderCourseObj;
                        $orderCourseObj->id = $course->id;
                        $orderCourseObj->name = $course->name;
                        $orderCourseObj->price = $course->price;
                        $orderCourseObj->real_price = $course->real_price;
                        $orderCourseObj->sale = $course->price * (100 - $course->pivot->percent) / 100;
                        $orderCourseObj->coupon = $course->pivot->coupon;
                        $orderCourseObj->coupon_value = $course->pivot->percent;
                        $order_content[] = $orderCourseObj;
                    }

                    $order->content = json_encode($order_content);

                    $order->save();



                    // Lưu vào bảng user_email
                    $alertEmail = Email::find(Config::get('app.email_order_complete'));
                    if($alertEmail){
                        $user_email  = new \App\UserEmail;
                        $user_email->user_id = Auth::id();
                        $user_email->email_id = $alertEmail->id;
                        $user_email->sender_user_id = 333;
                        $user_email->content = $alertEmail->content;
                        $user_email->title = $alertEmail->title;
                        $user_email->save();
                    }


                    $current_user->bought = \json_encode($bought);
                    $current_user->coins = $current_user->coins - $total_price;
                    $current_user->save();

                    return \Response::json(array('status' => '201', 'message' => 'Order has been created'));
                }
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

    public function clone(){
        // dd(\App\Category2::where('parent_id', 0)->get());
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://unica.vn/course/ngoai-ngu");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        echo $output;


    }

    // thêm banner cho category
    public function themBannerChoCategory(){
        $categories = Category::get();
        $cateArr = [
            ['Thiết kế', 0, 'fa-palette', 'banner_cat_design.png'],
            ['Công nghệ', 0, 'fa-wrench', 'banner_cat_technology.png'],
            ['Sức khoẻ, lối sống', 0, 'fa-book-medical', 'banner_cat_health.png'],
            ['Nuôi dạy con', 0, 'fa-baby', 'banner_cat_kid.png'],
            ['Ngôn ngữ', 0, 'fa-language', 'banner_cat_language.png'],
            ['Lối sống', 0, 'fa-tshirt', 'banner_cat_lifestyle.png'],
            ['Marketing', 0, 'fa-store', 'banner_cat_marketing.png'],
            ['Hôn nhân', 0, 'fa-home', 'banner_cat_marriage.png'],
            ['Phong cách sống', 0, 'fa-users', 'banner_cat_personal.png'],
            ['Nhiếp ảnh, dựng phim', 0, 'fa-camera-retro', 'banner_cat_photography.png']
        ];
        foreach ($categories as $key => $category) {
            $category->image = $cateArr[rand(0,9)][3];
            $category->save();
        }
        return response()->json([
            'message'=> 'done'
        ]);
    }

    public function duyetAllTeacher(){
        $teachers = Teacher::get();
        $teacher_done = [];
        foreach ($teachers as $key => $teacher) {
            $teacher->status = 1;
            $teacher->video_intro = "https://www.youtube.com/embed/U1_0b7CkucA";
            $teacher->course_count = $teacher->userRole->courses->count();
            $teacher->save();

            array_push($teacher_done, $teacher->id);

        }
        return response()->json([
            'message'=> 'done',
            'teacher_id' => $teacher_done
        ]);
    }

    public function demVideoChoUnit(){
        $units = Unit::get();
        $unit_done = [];
        foreach ($units as $key => $unit) {
            $videos = $unit->videos;
            $video_count = $videos->count();
            $unit->video_count = $video_count;
            $unit->save();

            array_push($unit_done, $unit->name);
        }

        return response()->json([
            'message'=> 'done',
            'unit_done' => $unit_done
        ]);
    }

    public function themVideoLink(){
        // $videos = Video::get();
        // foreach ($videos as $key => $video) {
        //     $video->url_video = '{"360": "vod/_definst_/360/dung-yeu-nua-em-met-roi-360.mp4","480": "vod/_definst_/480/dung-yeu-nua-em-met-roi-480.mp4","720": "vod/_definst_/720/dung-yeu-nua-em-met-roi-720.mp4","1080": "vod/_definst_/1080/dung-yeu-nua-em-met-roi-1080.mp4"}';
        //     $video->save();
        // }
        // Mail::to(Auth::user())->queue(new OrderCompleted());

        // return response()->json([
        //     'message'=> 'done',
        // ]);
    }

    public function becomeTeacher(){
        return view('frontends.become-teacher');
    }

    public function proceedCheckout()
    {
        return view('frontends.proceed-checkout');
    }

    public function fixDurationVideo(){
        $videos = Video::get();
        foreach($videos as $video){
            $video->duration = 376;
            $video->save();
        }
        echo "done";
    }

    public function fixDurationCourse(){
        $courses = Course::get();
        foreach($courses as $course){
            $course->duration = intval($course->video_count) * 376;
            $course->save();
        }
        echo "done";
    }

    public function fixWillLearn(){
        $courses = Course::get();
        foreach($courses as $course){
            $course->will_learn = str_replace("&nbsp","", $course->will_learn);
            $course->will_learn = str_replace(";","", $course->will_learn);
            $course->will_learn = str_replace("\t","", $course->will_learn);
            $course->will_learn = str_replace("<li></li>","", $course->will_learn);
            $course->will_learn = preg_replace('/(?:\s\s+|\n|\t)/', ' ', $course->will_learn);
            $course->will_learn = str_replace("<li> ","<li>", $course->will_learn);
            $course->will_learn = str_replace(" </li>","</li>", $course->will_learn);
            $course->will_learn = preg_replace('!\s+!', ' ', $course->will_learn);
            $course->save();
        }
        echo "done";
    }

    public function test(){

        // $courses = Course::get();
        // foreach($courses as $course){
        //     if(count($course->userRoles) != 0){
        //         echo(count($course->userRoles)-1).'<br>';
        //         $course->student_count = (count($course->userRoles)-1);
        //         $course->save();
        //     }else{
        //         $course->student_count = 0;
        //         $course->save();
        //     }
        // }
        // // $course = Course::find(1);
        // // dd($course->userRoles);

        // $teachers = Teacher::get();
        // foreach($teachers as $teacher){
        //     $teacher->student_count = 0;
        //     $teacher->save();
        // }

        // foreach($courses as $course){
        //     if($course->Lecturers()->first() && $course->Lecturers()->first()->teacher){
        //         $teacher = Teacher::find($course->Lecturers()->first()->teacher->id);
        //         if($teacher){
        //             $teacher-\>student_count += $course->student_count;
        //             $teacher->save();
        //         }
        //     }
        // }
        // echo "done";

        // DuongNT - Test isTeacher
        // $feature_course_count = 21;
        // $redunt = $feature_course_count%3;
        // if($redunt > 0){
        //     $feature_course_count = $feature_course_count - $redunt;
        // }else{
        //     $feature_course_count = $feature_course_count;
        // }
        // dd($feature_course_count);

    }

    public function seeMore(Request $request)
    {
        $end = false;
        if ($request->course_id != null && $request->take != null && $request->skip != null) {
            $course = Course::find($request->course_id);
            if ($course) {
                if($course->comments()->count() == $request->skip + $request->take){
                    $end = true;
                }
                $commentCourses = $course->takeComment($request->skip, $request->take);
                return view('components.question-answer-list', ['comments' => $commentCourses, 'end' => $end]);
            }
            return '';
        }
        return '';
    }

    public function aboutPage(){
        return view('frontends.footer-page.about');
    }
    public function faqPage(){
        return view('frontends.footer-page.faq');
    }
    public function termsOfServicePage(){
        return view('frontends.footer-page.terms-of-service');
    }
    public function paymentGuidePage(){
        return view('frontends.footer-page.payment-guide');
    }
    public function affiliatePage(){
        return view('frontends.footer-page.affiliate');
    }
    public function deleteCourse($course){
        $deleteCourse = \App\Course::find($course);
        if($deleteCourse){
            if($deleteCourse->units){
                foreach($deleteCourse->units as $unit){
                    if($unit->videos){
                        foreach($unit->videos as $video){
                            $video->delete();
                            \App\TempVideo::where("video_id", $video->id)->delete();
                            \App\TempDocument::where("video_id", $video->id)->delete();
                            \App\Document::where("video_id", $video->id)->delete();
                        }
                    }
                    $unit->delete();
                }
            }
            \App\TempCourse::where("course_id", $deleteCourse->id)->delete();
            // CourseTag::where("course_id", $course->id)->delete();
            // \App\OrderCourse::where("course_id", $deleteCourse->id)->delete();
            \App\UserCourse::where("course_id", $deleteCourse)->delete();
            $deleteCourse->delete();
        }
    }
}

class OrderCourseObj{
    public $id, $name, $price, $real_price, $sale, $coupon, $coupon_value;
}