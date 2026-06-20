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

class ReturnedForComplianceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct( public PoGppo $poGppo){}

    public function build()
    {
        return $this->subject('PO-GPPO Returned for Compliance')
            ->view('emails.po-gppo.returned-for-complience');
    }
}
