<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingLecture extends Model
{
    protected $fillable = [
        'lecture_id', 'user_id', 'score_id'
    ];

    public function lecture(){
    	return $this->belongsTo('App\User', 'lecture_id');
    }

    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
