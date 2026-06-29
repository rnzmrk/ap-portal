<?php

namespace App\Mail\PoGppo;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\PoGppo;

class PaidMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public PoGppo $poGppo)
    {
        //
    }

    public function build()
    {
        return $this->subject('Your PO/GPPo is ready for release')
                    ->view('emails.po-gppo.paid');
    }
}
