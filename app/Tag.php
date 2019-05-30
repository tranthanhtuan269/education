<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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
        'name', 'slug', 'status', 'image', 'category_id'
    ];

    // public function courses()
    // {
    //     return $this->belongsToMany('App\Course');
    // }

    public function category(){
    	return $this->belongsTo('App\Category');
    }


    public function courses(){
    	return $this->belongsToMany('App\Course');
    }
}
