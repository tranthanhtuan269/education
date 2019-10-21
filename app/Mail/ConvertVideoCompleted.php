<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Video;
use App\User;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $video;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Video $video, User $user)
    {
        $this->video = $video;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('duongconuong@tohsoft.com')
                    ->view('frontends.emails.convert-video-completed')
                    ->subject('Convert Video Completed')
                    ->with([
                        'user' => $this->user,
                        'video' => $this->video,
                        'mailSubject' => 'Order Completed',
                        'mailContent' => 'Alibaba',
                    ]);
    }
}
