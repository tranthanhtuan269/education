<?php
namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;
use App\Category;
use App\Course;

class HomeController extends Controller{

    public function home(){
        $category = Category::get();
        $feature_category = Category::where('featured', 1)->orderBy('featured_index', 'asc')->limit(10)->get();
        // feature_course = trendding_course
        $feature_course = Course::where('featured', 1)->orderBy('featured_index', 'asc')->limit(8)->get();
        $best_seller_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();
        $new_course = Course::orderBy('sale_count', 'asc')->limit(8)->get();

        // dd(Course::find(1)->Lecturers()->user->name);
        return view('frontends.home', compact('category', 'feature_category', 'feature_course', 'best_seller_course', 'new_course'));
    }
    public function memberCard(){
        return view('frontends.member-card');
    }

    public function courseCategory(){
        return view('frontends.course-category');
    }

    public function detailTeacher(){
        return view('frontends.detail-teacher');
    }

    public function courseLearning(){
        return view('frontends.course-learning');
    }

    public function courseDetail() {
        return view('frontends.course-detail');
    }

}