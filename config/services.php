<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\Logger;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator)
{
    $parameters = $configurator->parameters();

    $parameters
        ->set('mailer.gmail_user', 'lior@gmail.com')
        ->set('mailer.gmail_password', '123456');

    $services = $configurator->services();

    $services->defaults()->autowire(true);

    $services
        ->set('order_controller', OrderController::class)
        ->public()
        ->call('sayHello', ['Bonjour à tous', 33])

        ->set('database', Database::class)

        ->set('logger', Logger::class)

        ->set('texter.sms', SmsTexter::class)
        ->args(['service.sms.com', 'apikey1234'])
        ->tag('with_logger')

        ->set('mailer.gmail', GmailMailer::class)
        ->args(['%mailer.gmail_user%', '%mailer.gmail_password%'])
        ->tag('with_logger')

        ->set('mailer.smtp', SmtpMailer::class)
        ->args(['smtp://localhost', 'root', '123'])

        ->set('texter.fax', FaxTexter::class)

        ->alias('App\Controller\OrderController', 'order_controller')->public()
        ->alias('App\Database\Database', 'database')
        ->alias('App\Mailer\GmailMailer', 'mailer.gmail')
        ->alias('App\Mailer\SmtpMailer', 'mailer.smtp')
        ->alias('App\Mailer\MailerInterface', 'mailer.gmail')
        ->alias('App\Texter\SmsTexter', 'texter.sms')
        ->alias('App\Texter\FaxTexter', 'texter.fax')
        ->alias('App\Texter\TexterInterface', 'texter.sms')
        ->alias('App\Logger', 'logger');
};