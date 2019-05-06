<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
    }


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
}
