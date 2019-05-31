<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingTeacher extends Model
{
    protected $table = 'teacher_ratings';

    protected $fillable = [
        'teacher_id', 'user_id', 'score_id'
    ];

    public function lecture(){
    	return $this->belongsTo('App\User', 'teacher_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
