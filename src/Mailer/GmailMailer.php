<?php

namespace App\Mailer;

use App\Texter\Logger;

class GmailMailer implements MailerInterface
{

    protected $user;
    protected $password;
    protected $logger;

    public function __construct(string $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        $this->logger->log("Ca marche dans les mails");
    }

    public function send(Email $email)
    {
        var_dump("ENVOI VIA GMAILMAILER", $email);
    }
}
