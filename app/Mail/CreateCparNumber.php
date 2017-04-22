<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateCparNumber extends Mailable
{
    use Queueable, SerializesModels;

	/**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from('no-reply@newsim.ph')
                    ->markdown('emails.cpars.create-cpar-number');
    }
}
