<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $course_link;
    protected $course_name;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($course_link, $course_name, $email)
    {
        $this->course_link = $course_link;
        $this->course_name = $course_name;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $content_mail = [
            'course_link'      => $this->course_link,
            'course_name'      => $this->course_name,
        ];

        // $email = ['trinhnk@tohsoft.com'];
        $email = [$this->email];

        \Mail::send('backends.emails.gift', $content_mail, function($message) use ($email) {
            $message->from('nhansu@tohsoft.com', 'Courdemy');
            $title = "[Courdemy] Tặng khóa học miễn phí từ Courdemy";
            $message->to($email)->subject($title);
        });
    }
}