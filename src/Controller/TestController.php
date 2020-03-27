<?php


namespace App\Controller;


use App\Database\Database;
use App\Database\MongoDb;
use App\Mailer\MailerInterface;

class TestController
{
    public function __construct(MongoDb $database, MailerInterface $mailer)
    {
       var_dump("DATABASE : ", $database);
       var_dump("MAILER : ", $mailer);
    }
}