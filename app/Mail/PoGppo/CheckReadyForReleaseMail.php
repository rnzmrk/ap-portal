<?php

namespace App\Mail\PoGppo;

use App\Models\PoGppo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckReadyForReleaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PoGppo $poGppo
    ) {}

    public function build()
    {
        return $this->subject('Your PO/GPPo is ready for release')
            ->view('emails.po-gppo.check-ready-for-release');
    }
}
