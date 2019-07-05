<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name', 'index', 'url_video', 'link_video', 'duration', 'unit_id', 'state'
    ];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function documents(){
        return $this->hasMany('App\Document');
    }

    public static function acceptMulti($id_list, $status){
        $checkVideo = Video::whereIn('id', $id_list);
        return ($checkVideo->update(['state' => $status]) > 0);
    }

    public static function delMulti($id_list){
        $checkVideo = Video::whereIn('id', $id_list);
        return ($checkVideo->delete() > 0);
    }
}
