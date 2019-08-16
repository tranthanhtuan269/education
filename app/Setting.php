<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'percent_feature_course'
    ];

    public $timestamps = false;
}
