<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\User;
use App\Email;

class DiscountNot extends Mailable
{
    use Queueable, SerializesModels;
    

    protected $user;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Email $email )
    {
        $this->user = $user;
        $this->email = $email;
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
                    ->subject($this->email->title)
                    ->with([
                        'userName' => $this->user->name,
                        'mailSubject' => $this->email->title,
                        'mailContent' => $this->email->content,
                    ]);
    }
}
