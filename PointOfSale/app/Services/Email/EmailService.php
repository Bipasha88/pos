<?php

namespace App\Services\Email;

use Illuminate\Support\Facades\Mail;

class EmailService implements IEmailService {

    public function SendSingleEmail($receiverEmail, $receiverName, $subject, $body, $template) {
        Mail::send($template, $body, function($message) use ($subject, $receiverEmail, $receiverName) {
            $message->to($receiverEmail, $receiverName)
                ->subject($subject);
        });
    }
}
