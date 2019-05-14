<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'status', 'cat_id'
    ];

    // public function courses()
    // {
    //     return $this->belongsToMany('App\Course');
    // }

    public function category(){
    	return $this->belongsTo('App\Category', 'cat_id');
    }
}
