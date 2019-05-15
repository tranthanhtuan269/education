<?php
namespace App\Http\Controllers\Frontends;

use App\Category;
use App\Course;
use App\Teacher;
use App\Unit;
use App\Video;

class HomeController extends Controller
{

    public function home()
    {   
        $feature_category = Category::where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
        // feature_course = trendding_course
        $feature_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $popular_teacher = Teacher::getTeacherBestVote();

        return view('frontends.home', compact('feature_category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher'));
    }

    public function showCategory($cat)
    {
        $id_cat = Category::where('slug', $cat)->value('id');
        $feature_category = Category::where('featured', 1)->orderBy('featured_index', 'asc')->limit(5)->get();
        // feature_course = trendding_course
        $feature_course = Course::where('category_id', $id_cat)->where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $popular_teacher = Teacher::getTeacherBestVote();
        return view('frontends.course-category', compact('category', 'feature_category', 'feature_course', 'best_seller_course', 'new_course', 'popular_teacher'));
    }

    public function showCourse($course)
    {
        $course = Course::where('slug', $course)->first();
        $related_course = Course::where('category_id', $course->category_id)->limit(4)->get();
        $info_course = Course::find($course->id);

        // echo '<pre>';
        // print_r($info_course->units);die;
        return view('frontends.course-detail', compact('related_course', 'info_course', 'unit'));
    }

    public function showTeacher($id_teacher)
    {
        // dd(Teacher::find(2)->userRole->user->avatar);
        $info_teacher = Teacher::find($id_teacher);
        // feature_course = trendding_course
        $feature_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
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
        // feature_course = trendding_course
        $feature_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $popular_teacher = Teacher::get();

        return view('frontends.course-category', compact('category', 'feature_category', 'feature_course', 'best_seller_course', 'new_course'));
    }

    public function detailTeacher()
    {
        return view('frontends.detail-teacher');
    }

    public function courseLearning()
    {
        return view('frontends.course-learning');
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
}