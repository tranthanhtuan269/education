<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $fillable = [
        'comment_id', 'user_id', 'state'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
