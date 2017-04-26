<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CparReviewed extends Mailable
{
    use Queueable, SerializesModels;
    use SoftDeletes;

    public $cpar;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cpar)
    {
        $this->cpar = \App\Cpar::find($cpar);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.cpars.cpar-reviewed');
    }
}
