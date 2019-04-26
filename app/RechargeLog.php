<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RechargeLog extends Model
{
    protected $fillable = [
        'amount', 'message', 'payment_id', 'user_id'
    ];

    public function payment(){
    	return $this->belongsTo('App\Payment');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
