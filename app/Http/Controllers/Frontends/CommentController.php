<?php
namespace App\Http\Controllers\Frontends;

use App\Category;
use App\Course;
use App\Teacher;
use App\Unit;
use App\Video;

class CommentController extends Controller
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


}