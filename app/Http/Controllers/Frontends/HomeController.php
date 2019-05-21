<?php
namespace App\Http\Controllers\Frontends;

use App\RatingCourse;
use App\Category;
use App\Teacher;
use App\Course;
use App\Video;
use App\Unit;
use App\Tag;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function test(){
        $permissions = \App\Permission::get();
        foreach($permissions as $permission){
            echo '$per = new Permission; <br/>';
            echo '$per->name = "'.$permission->name .'"; <br/>';
            echo '$per->route = "' .$permission->route .'"; <br/>';
            echo '$per->group = ' .$permission->group .'; <br/>';
	        echo '$per->save(); <br/> <br/>';
        }
    }

    public function comingSoon(){
        return view('frontends.coming-soon');
    }

    public function listCourse(Request $request){
     
        $type = trim($request->get('type'));
        if ($type == 'best-seller') {
           $list_course = Course::orderBy('sale_count', 'asc')->paginate(8); 
           $title = 'Best seller';
        } elseif($type == 'new') {
            $list_course = Course::orderBy('id', 'desc')->paginate(16);
            $title = 'New';
        } elseif($type == 'trendding') {
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
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('id', 'desc')->limit(8)->get();
        $popular_teacher = Teacher::getTeacherBestVote();

        return view('frontends.home', compact('feature_category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher'));
    }

    public function search(Request $request){
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
        if($cat_id){
            $tags = Tag::where('category_id', $cat_id)->get();
            $feature_course = Course::where('category_id', $cat_id)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
            $best_seller_course = Course::where('category_id', $cat_id)->orderBy('sale_count', 'asc')->limit(8)->get();
            $new_course = Course::where('category_id', $cat_id)->orderBy('id', 'desc')->limit(8)->get();
            $popular_teacher = Teacher::getTeacherBestVote();
            return view('frontends.category', compact('category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher', 'tags'));
        }
        return abort(404);
    }

    public function showCourse($course)
    {
        $course = Course::where('slug', $course)->first();
        if(\Auth::check()){
            if($course){
                $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                // dd($info_course->comments[0]->likeCheckUser());
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit', 'ratingCourse'));
            }
        }else{
            if($course){
                $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                return view('frontends.course-detail', compact('related_course', 'info_course', 'unit'));
            }
        }
        return abort(404);
    }

    public function showTeacher($id_teacher)
    {
        $info_teacher = Teacher::find($id_teacher);
        $feature_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('id', 'desc')->limit(8)->get();
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
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('id', 'asc')->limit(8)->get();
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
        if(\Auth::check()){
            if($course){
                $ratingCourse = RatingCourse::where('course_id', $course->id)->where('user_id', \Auth::id())->first();
                $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
                $info_course = Course::find($course->id);
                return view('frontends.course-learning', compact('related_course', 'info_course', 'unit', 'ratingCourse'));
            }
        }else{
            if($course){
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

    public function studentProfile(){
        return view('frontends.student-profile');
    }
    
    public function courseList(){
        return view('frontends.course-list');
    }
    public function logout(){
        Auth::logout();
    }
}