<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'payment_id', 'user_id', 'status'
    ];

    public function payment(){
    	return $this->belongsTo('App\Payment');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }
}
