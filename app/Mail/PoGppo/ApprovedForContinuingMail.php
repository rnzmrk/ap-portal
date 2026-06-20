<?php

namespace App\Mail\PoGppo;

use App\Models\PoGppo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovedForContinuingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PoGppo $poGppo
    ) {}

    public function build()
    {
        return $this->subject('Your PO/GPPo has been approved for continuing')
            ->view('emails.po-gppo.approved-for-continuing');
    }
}
