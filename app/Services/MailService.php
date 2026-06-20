<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function send(
        string $email,
        Mailable $mail
    ): void {
        Mail::to($email)->send($mail);
    }

    public function sendToRole(
        string $role,
        Mailable $mail
    ): void {
        $users = User::where('role', $role)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send($mail);
        }
    }
}
