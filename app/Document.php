<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title','video_id', 'url_document', 'size'];

    public function video(){
        return $this->belongsTo('App\Video');
    }
}
