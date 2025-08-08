<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class eventmailaproveorreject extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $event;
    public function __construct($event)
    {
        $this->event =$event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){

        return $this->view('emails.eventmailaproveorreject');
    }
}
