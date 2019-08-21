<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\User;
use App\Course;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
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
                    ->view('frontends.emails.order-completed-not')
                    ->subject('Order Completed')
                    ->with([
                        'user' => $this->user,
                        'order' => $this->order,
                        'courses' => $this->order->courses,
                        'mailSubject' => 'Order Completed',
                        'mailContent' => 'Alibaba',
                    ]);
    }
}
