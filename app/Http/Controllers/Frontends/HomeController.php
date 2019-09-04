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
use App\Video;
use App\Setting;
use App\Mail\OrderCompleted;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\UserRole;

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
            $title = 'Các khoá học bán chạy';
        } elseif ($type == 'new') {
            $list_course = Course::where('status', 1)->orderBy('id', 'desc')->paginate(16);
            $title = 'Các khóa học mới nhất';
        } elseif ($type == 'trendding') {
            $list_course = Course::where('status', 1)->where('featured', 1)->orderBy('featured_index', 'asc')->paginate(16);
            $title = 'Các khóa học thịnh hành';
        }

        return view('frontends.list-course-by-type', compact('list_course', 'title'));
    }

    public function home()
    {
        $feature_category = Category::withCount('courses')->where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
        // Duong NT// trending = feature courses
        $percent_feature_course = Setting::where('name', 'percent_feature_course')->first()->value;
        $feature_course = Course::where('status', 1)->orderBy('featured_index', 'asc')->get();
        $feature_course = $feature_course->filter(function ($value, $key) use ($percent_feature_course) {
            if($value->price < $value->real_price){
                $percent = 100 - intval($value->price/$value->real_price)*100;
            }else{
                $percent = 0;
            }
            return ($percent > intval($percent_feature_course)) || $value->featured == 1 ;
        })->values(); //reindex the collection
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
            
            $category = Category::where('slug', $cat)->first();
            
            $tags = Tag::where('category_id', $cat_id)->get();
            
            $feature_course = Course::where('status', 1)->where('category_id', $cat_id)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
            
            $best_seller_course = Course::where('status', 1)->where('category_id', $cat_id)->orderBy('sale_count', 'desc')->limit(8)->get();
            
            $new_course = Course::where('status', 1)->where('category_id', $cat_id)->orderBy('id', 'desc')->limit(8)->get();
            
            // $popular_teacher = Teacher::getTeacherBestVote();

            $popular_teacher = Teacher::getTeacherBestVote($cat_id);

            
            // $filtered_teachers = $popular_teacher->filter(function ($teacher, $key) use ($cat_id){
            //     $courses = $teacher->courses->where('category_id', $cat_id);

            //     return $courses->cate;
            // });
            return view('frontends.category', compact('category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher', 'tags' ));
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
        if($course){
            if($course->status == 1){
                if ($course) {
                    $course->view_count = $course->view_count + 1;
                    $course->save();
                }
                
                if (\Auth::check()) {
                    if ($course) {
                        $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                        $related_course = Course::where('category_id', $course->category_id)->where('id','!=',$course->id)->where('status', 1)->limit(4)->get();
                        $info_course = Course::find($course->id);
                        return view('frontends.course-detail', compact('related_course', 'info_course', 'ratingCourse'));
                    }
                } else {
                    if ($course) {
                        $related_course = Course::where('category_id', $course->category_id)->where('id','!=',$course->id)->where('status', 1)->limit(4)->get();
                        $info_course = Course::find($course->id);
                        return view('frontends.course-detail', compact('related_course', 'info_course'));
                    }
                }
            }else{
                if(\Auth::check() && Auth::user()->userRolesTeacher()->userCoursesByTeacher()->where('id', $course->id)->first() != null){
                    $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                    $related_course = Course::where('category_id', $course->category_id)->where('id','!=',$course->id)->where('status', 1)->limit(4)->get();
                    $info_course = Course::find($course->id);
                    return view('frontends.course-detail', compact('related_course', 'info_course', 'ratingCourse'));
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
        $coupon = Coupon::where('name', $request->coupon)->where('course_id', $request->course_id)->first();
        if ($coupon) {
            return \Response::json(array('status' => '200', 'coupon' => $coupon, 'coupon_value' => $coupon->value));
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

                $coupon = null;
                $coupon_value;
                $coupon_name;

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
                        $coupon = Coupon::where('name', $item["coupon_code"])->where('course_id', $item["id"])->first();
                        $course = Course::find($item['id']);
                        if ($course) {
                            if($coupon){
                                $total_price =  $total_price + $course->price * (100 - $coupon->value) / 100;
                            }else{
                                $total_price += $course->price;
                            }

                            $bought[] = $item['id']; //Them vao trường đã mua của user TuanTT
                            $video_count = $course->video_count;
                            $units = $course->units;
                            $first_video_index = 1;
                            $first_video_id = $course->units[0]->videos[0]->id;
                            $user_course_videos = [];
                            
                            //DuongNT - Tạo array video đã xem
                            foreach ($units as $key => $unit) {
                                if($unit->video_count > 0){
                                    $unit_arr = [];
                                    for ($k=0; $k < $unit->video_count; $k++) { 
                                        array_push($unit_arr, 0);                                    
                                    }
                                    array_push($user_course_videos, $unit_arr);
                                }
                            }
                            $videoJson = new VideoJson;
                            $videoJson->videos = $user_course_videos;
                            $videoJson->learning = 1;
                            $videoJson->learning_id = $first_video_id;

                            $videoJson = json_encode($videoJson);

                            $course->userRoles()->attach($user_role_id->id, ['videos' => $videoJson]);
                            $order->courses()->attach($item['id']);
                        }

                        // lưu vào bảng teacher của mỗi course để tăng số lượng học viên cho mỗi teacher
                        $teacher = $course->Lecturers()->first()->teacher;
                        $teacher->student_count += 1;
                        $teacher->save();

                        $course2 = Course::find($item['id']);
                        $course2->student_count += 1;
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
                // dd($order);
                $order->save();

                // Lưu vào bảng user_email
                $user_email  = new \App\UserEmail;
                $user_email->user_id = Auth::id();
                $user_email->email_id = \App\Email::where('title', 'Thông báo mua hàng thành công')->first()->id;
                $user_email->sender_user_id = 333;
                $user_email->save();

                
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
            $course->will_learn = "<ul><li>" . str_replace(";;", "</li><li>", $course->will_learn) . "</li></ul>";
            $course->save();
        }
        echo "done";   
    }
}

class VideoJson
{
    public $videos, $learning, $learning_id;
}
