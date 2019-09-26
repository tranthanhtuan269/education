<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class TempCourse extends Model
{
    //
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
        'course_id',
        'name', 
        'short_description',
        'slug',
        'image',
        'category_id',
        'price',
        'real_price',
        'author',
        'description',
        'will_learn',
        'requirement',
        'level',
        'approx_time',
        'link_intro',
        'status'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
