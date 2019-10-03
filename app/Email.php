<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'status',
        'create_user_id',
        'update_user_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_email', 'email_id', 'user_id');
    }
}
