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
}
