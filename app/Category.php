<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Category extends Model
{
    protected $fillable = [
        'name', 'parent_id', 'featured', 'featured_index', 'course_count'
    ];

    public function courses()
    {
        return $this->hasMany('App\Course');
    }

    public function parent(){
    	return $this->belongsTo('App\Category', 'parent_id');
    }

    public function children(){
    	return $this->hasMany('App\Category', 'parent_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
