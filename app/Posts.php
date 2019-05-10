<?php

namespace App;
use App\Menu;
use DB;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model{
    
    protected $table = "posts";
    public $timestamp=false;
    // public function posts()
    // {
    //     return $this->hasMany('App\Posts','author_id');
    // }
}
