<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Category extends Model
{
    protected $fillable = [
        'name', 'featured', 'featured_index', 'course_count','slug'
    ];

    public function courses()
    {
        return $this->hasMany('App\Course');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag','cat_id');
    }
}
