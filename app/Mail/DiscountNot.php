<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\User;
use App\MailLog;

class DiscountNot extends Mailable
{
    use Queueable, SerializesModels;
    

    protected $user;
    protected $mail_log;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, MailLog $mail_log )
    {
        $this->user = $user;
        $this->mail_log = $mail_log;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('duongconuong@tohsoft.com')
                    ->view('backends.emails.discount-not')
                    ->subject($this->mail_log->title)
                    ->with([
                        'userName' => $this->user->name,
                        'mailSubject' => $this->mail_log->title,
                        'mailContent' => $this->mail_log->content,
                    ]);
    }
}
