<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name', 
        'value',
        'expired',
        'status',
        'course_id'
    ];
    
    public $timestamps=false;
}
