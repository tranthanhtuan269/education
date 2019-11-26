<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CommentCourse extends Model
{
    protected $fillable = [
        'content', 'user_role_id', 'course_id', 'parent_id', 'score', 'state'
    ];
    
    public function userRole(){
        return $this->belongsTo('App\UserRole');
    }

    public function course(){
    	return $this->belongsTo('App\Course');
    }

    public function commentLike(){
    	return $this->hasOne('App\CommentLike','comment_id');
    }
    public function parent(){
    	return $this->belongsTo('App\CommentCourse', 'parent_id');
    }

    public function children(){
        $arr_comment_id = \DB::table('comment_courses')
                        ->join('user_roles', 'user_roles.id', '=', 'comment_courses.user_role_id')
                        ->join('users', 'users.id', '=', 'user_roles.user_id')
                        ->where('users.status', 1)
                        ->pluck('comment_courses.id');
    	return $this->hasMany('App\CommentCourse', 'parent_id')->whereIn('id', $arr_comment_id)->orderBy('comment_courses.created_at', 'desc');
    }

    public function like(){
        return $this->hasMany('App\CommentLike', 'comment_id');
    }

    public function likeCheckUser(){
        if(Auth::check()){
            if($this->like()->where('user_id', Auth::id())->where('state', 1)->first()){
                return 1;
            }
        }
        return 0;
    }

    public function unlikeCheckUser(){
        if(Auth::check()){
            if($this->like()->where('user_id', Auth::id())->where('state', -1)->first()){
                return 1;
            }
        }
        return 0;
    }
}
