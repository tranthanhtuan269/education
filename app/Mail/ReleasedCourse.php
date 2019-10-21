<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Course;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $course;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Course $course, User $user)
    {
        $this->course = $course;
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
                    ->view('frontends.emails.release-course')
                    ->subject('Khóa học đã được duyệt')
                    ->with([
                        'user' => $this->user,
                        'course' => $this->course,
                        'mailSubject' => 'Khóa học đã được duyệt',
                        'mailContent' => 'Khóa học đã được duyệt thành công',
                    ]);
    }
}
