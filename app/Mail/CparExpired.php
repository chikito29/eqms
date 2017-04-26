<?php

namespace App\Mail;

use App\Cpar;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CparExpired extends Mailable
{
    use Queueable, SerializesModels;

    public $cpar;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cpar)
    {
        $this->cpar = Cpar::find($cpar);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.cpars.expired');
    }
}
