<?php

namespace App\Mail\PoGppo;

use App\Models\PoGppo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PoGppo $poGppo
    ) {}

    public function build()
    {
        return $this->subject('PO-GPPO Submitted')
            ->view('emails.po-gppo.submitted');
    }
}
