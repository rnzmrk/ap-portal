<?php

namespace App\Mail\JoEvaluation;

use App\Models\JoEvaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JoEvaluation $joEvaluation
    ) {}

    public function build()
    {
        return $this->subject('JO Evaluation Submitted')
            ->view('emails.jo-evaluation.submitted');
    }
}
