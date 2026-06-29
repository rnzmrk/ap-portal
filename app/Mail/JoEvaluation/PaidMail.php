<?php

namespace App\Mail\JoEvaluation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\JoEvaluation;

class PaidMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct( public JoEvaluation $joEvaluation )
    {

    }

    public function build()
    {
        return $this->subject('JO Evaluation Paid')
            ->view('emails.jo-evaluation.paid');
    }


}
