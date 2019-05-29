<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name', 
        'value',
        'expired',
        'status'
    ];
    
    public $timestamps=false;
}
