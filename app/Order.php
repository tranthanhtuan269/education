<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'payment_id', 'user_id', 'total_price', 'coupon', 'content', 'status'
    ];

    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i:s',
    ];


    public function payment(){
    	return $this->belongsTo('App\Payment');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'order_details');
    }
}
