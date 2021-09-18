<?php

namespace App\Services\Email;

interface IEmailService {
    public function SendSingleEmail($receiverEmail, $receiverName, $subject, $body, $template);
}
