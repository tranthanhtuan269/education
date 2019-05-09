<?php
namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests;


class HomeController extends Controller{
    public function home(){
        return view('frontends.home');
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
    public function courseList(){
        return view('frontends.course-list');
    }
    public function studentProfile(){
        return view('frontends.student-profile');
    }
}