<?php

namespace App\Mail\JoEvaluation;

use App\Models\JoEvaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentForReleaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JoEvaluation $joEvaluation
    ) {}

    public function build()
    {
        return $this->subject('Payment for Release')
            ->view('emails.jo-evaluation.payment-for-release');
    }
}
