<?php

namespace App\Texter;

use App\Mailer\MailerInterface;

class SmsTexter implements TexterInterface
{
    protected $serviceDsn;
    protected $key;
    protected $logger;

    public function __construct(string $serviceDsn, string $key, MailerInterface $mailer)
    {
        $this->serviceDsn = $serviceDsn;
        $this->key = $key;
    }

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        $this->logger->log("Ca marche dans les sms");
    }

    public function send(Text $text)
    {
        var_dump("ENVOI DE SMS : ", $text);
    }
}
