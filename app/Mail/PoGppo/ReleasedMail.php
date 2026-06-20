<?php

namespace App\Mail\PoGppo;

use App\Models\PoGppo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReleasedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PoGppo $poGppo
    ) {}

    public function build()
    {
        return $this->subject('Your PoGppo has been released')
            ->view('emails.po-gppo.released');
    }
}
