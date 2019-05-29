<?php

namespace App;
use App\Menu;
use DB;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{    
    public $timestamps=false;
    protected $table = "posts";
    // public function posts()
    // {
    //     return $this->hasMany('App\Posts','author_id');
    // }
}
