<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Category;

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

    protected $fillable = [
        'name', 'parent_id', 'featured', 'featured_index', 'course_count','slug'
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
        return $this->hasMany('App\Tag','category_id');
    }

    public function children()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

}
