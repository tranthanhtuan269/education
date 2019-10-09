<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public $timestamps = false;


    protected $fillable = [
        'name', 'parent_id', 'featured', 'featured_index', 'course_count','slug', 'image'
    ];

    public function courses()
    {
        return $this->hasMany('App\Course')->where('status', 1);
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag','category_id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function childrenHavingCourse()
    {
        return $this->hasMany('App\Category', 'parent_id')->whereHas('courses', function ($query) {
            $query->where('status', 1);
        });
    }

    public function parent()
    {
        return $this->hasOne('App\Category', 'id', 'parent_id');
    }

    public static function getCoursesOfCategory(){
        return \DB::table('categories')
        ->join('courses', 'courses.category_id', '=', 'categories.id')
        ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
        ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
        ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
        ->join('users', 'users.id', '=','user_roles.user_id')
        ->where('teachers.status', 1)
        ->where('courses.status', 1)
        ->where('categories.parent_id', '<>', 0)
        ->orderBy('categories.featured_index', 'asc')
        // ->where('courses.category_id', $cat_id)
        // ->where('categories.featured', 1)
        ->groupBy('categories.id', 'categories.image', 'categories.slug', 'categories.name')
        ->select('categories.id', 'categories.image', 'categories.slug', 'categories.name', \DB::raw('count(categories.id) as category_count'))->get();
    }
}
