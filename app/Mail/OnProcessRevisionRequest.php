<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RevisionRequest;

class OnProcessRevisionRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $revisionRequest;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RevisionRequest $revisionRequest)
    {
        $this->revisionRequest = $revisionRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Processing Revision Request')
                    ->markdown('emails.revisionrequests.on-process');
    }
}
