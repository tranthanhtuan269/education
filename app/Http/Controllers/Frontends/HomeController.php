<?php
namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Frontends\Requests\UpdateProfileUserRequest;
use App\Category;
use App\Course;
use App\RatingCourse;
use App\Tag;
use App\Teacher;
use App\User;
use App\Helper\Helper;

class HomeController extends Controller
{

    public function test()
    {
        // echo Helper::formatDate('d/m/Y', '20/10/2000', 'Y-m-d');die;
        // echo public_path(Auth::user()->avatar);die;
        // $permissions = \App\Permission::get();
        // foreach($permissions as $permission){
        //     echo '$per = new Permission; <br/>';
        //     echo '$per->name = "'.$permission->name .'"; <br/>';
        //     echo '$per->route = "' .$permission->route .'"; <br/>';
        //     echo '$per->group = ' .$permission->group .'; <br/>';
        //     echo '$per->save(); <br/> <br/>';
        // }
    }

    public function uploadImage(UpdateProfileUserRequest $request)
    {
        $file_name = 'avatar.jpg';
        if ($request->link_base64 != '') {
            // Xóa avatar cũ nếu có
            if (file_exists(public_path(Auth::user()->avatar))) {
                unlink(public_path(Auth::user()->avatar));
            }

            $img_file = $request->link_base64;
            list($type, $img_file) = explode(';', $img_file);
            list(, $img_file) = explode(',', $img_file);
            $img_file = base64_decode($img_file);
            $file_name = time() . '.png';
            file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
        }
       
        // $requestData = $request->all();
        // $requestData['birthday'] = Helper::formatDate('d/m/Y', $request->birthday, 'Y-m-d');
        // $requestData['avatar'] = 'images/' . $file_name;
        // $requestData['email'] = 'demo@gmail.com';
        // // echo '<pre>';
        // // print_r($requestData);die;
        // $user = User::create($requestData);
        // echo Helper::formatDate('d/m/Y', $request->birthday, 'Y-m-d');die;
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = Auth::user()->email;
        $user->password = Auth::user()->password;
        $user->birthday = date('Y-m-d');
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->avatar = 'images/' . $file_name;
        $user->save();

        return response()->json(['success' => 'Change profile success!', 'status' => 200]);
    }
    public function uploadImageDemo(Request $request)
    {
        echo 1;
    }

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
        $feature_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'desc')->limit(8)->get();
        $new_course = Course::orderBy('id', 'desc')->limit(8)->get();
        $popular_teacher = Teacher::getTeacherBestVote();

        return view('frontends.home', compact('feature_category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $results = [];
        if ($keyword != '') {
            $keyword = trim($request->get('keyword'));
            $results = Course::where('name', 'LIKE', "%$keyword%")->paginate(8);
        }
        return view('frontends.search', compact('results'));
    }

    public function showCategory($cat)
    {
        $cat_id = Category::where('slug', $cat)->value('id');
        if ($cat_id) {
            $tags = Tag::where('category_id', $cat_id)->get();
            $feature_course = Course::where('category_id', $cat_id)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
            $best_seller_course = Course::where('category_id', $cat_id)->orderBy('sale_count', 'desc')->limit(8)->get();
            $new_course = Course::where('category_id', $cat_id)->orderBy('id', 'desc')->limit(8)->get();
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
                $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                // dd($info_course->comments[0]->likeCheckUser());
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit', 'ratingCourse'));
            }
        } else {
            if ($course) {
                $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit'));
            }
        }
        return abort(404);
    }

    public function showTeacher($id_teacher)
    {
        $user = User::find($id_teacher);
        $info_teacher = Teacher::find($id_teacher);
        $feature_course = $user->userRolesTeacher()[0]->userCoursesByFeature();
        $best_seller_course = $user->userRolesTeacher()[0]->userCoursesByTrendding();
        $new_course = $user->userRolesTeacher()[0]->userCoursesByNew();
        return view('frontends.detail-teacher', compact('info_teacher', 'feature_category', 'feature_course', 'best_seller_course', 'new_course'));
    }

    public function memberCard()
    {
        return view('frontends.member-card');
    }

    public function courseCategory()
    {
        $category = Category::get();
        $feature_category = Category::where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
        $feature_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'desc')->limit(8)->get();
        $new_course = Course::orderBy('id', 'desc')->limit(8)->get();
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
                $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                return view('frontends.course-learning', compact('related_course', 'info_course', 'unit', 'ratingCourse'));
            }
        } else {
            if ($course) {
                $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                return view('frontends.course-learning', compact('related_course', 'info_course', 'unit'));
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
}
