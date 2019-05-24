<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Auth;

class Course extends Model
{
    //
    protected $fillable = [
        'name', 
        'slug',
        'category_id',
        'price',
        'real_price',
        'from_sale',
        'to_sale',
        'duration',
        'downloadable_count',
        'video_count',
        'student_count',
        'star_count',
        'vote_count',
        'sale_count',
        'view_count',

        'description',
        'will_learn',
        'requirement',
        'level',
        'approx_time',

        'featured',
        'featured_index',
        'promotion',
        'promotion_index',
        'five_stars',
        'four_stars',
        'three_stars',
        'two_stars',
        'one_stars',

        'status'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function userRoles()
    {
        return $this->belongsToMany('App\UserRole', 'user_courses');
    }

    public function Lecturers(){
        if($this->userRoles){
            return $this->userRoles()->where('role_id', \Config::get('app.teacher'))->get();
        }else{
            return [];
        }
    }

    public function units()
    {
    	return $this->hasMany('App\Unit');
    }

    public function comments()
    {
        if(Auth::check()){
            $sefl = $this;
            return $this->hasMany('App\CommentCourse')->where(
                function($q) use ($sefl){
                   $q->where('state', 1)
                     ->orWhere('user_role_id', Helper::getUserRoleOfCourse($sefl->id)->user_role_id);
               })->orderBy('created_at', 'desc');
        }else{
            return $this->hasMany('App\CommentCourse')->where('state', 1);
        }
    }

    public function takeComment($from, $take){
        return $this->comments()->skip($from)->take($take)->get();
    }
    
    public function videos()
    {
    	return $this->belongsToMany('App\Video');
    }
    
}
