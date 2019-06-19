<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMailLog extends Model
{

    protected $fillable = [
        'user_role_id', 'mail_log_id', 'sender_user_id',
    ];

    protected $table = 'user_mail_log';

    public function detail_mail_log()
    {
        return $this->belongsto('App\MailLog', 'mail_log_id');
    }
}