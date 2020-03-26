<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\TexterInterface;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

$container->setParameter('mailer.gmail_user', 'lior@gmail.com');
$container->setParameter('mailer.gmail_password', '123456');

/*
$controllerDefinition = new Definition(OrderController::class, [
    new Reference('database'),
    new Reference('mailer.gmail'),
    new Reference('texter.sms')
]);
$controllerDefinition->addMethodCall('sayHello', [
   'Bonjour à tous',
   33
]);
$container->setDefinition('order_controller', $controllerDefinition);
*/

$container->autowire('order_controller', OrderController::class)
    ->setPublic(true)
    //->setArguments([
    //    new Reference(Database::class),
    //    new Reference(GmailMailer::class),
    //    new Reference(SmsTexter::class)
    //])
    ->addMethodCall('sayHello', [
        'Bonjour à tous',
        33
    ]);

/*
$databaseDefinition = new Definition(Database::class);

$container->setDefinition('database', $databaseDefinition);
//$container->set('database', new Database());*/

/*$container->register('database', Database::class)
        ->setAutowired(true);*/

$container->autowire('database', Database::class);

/*
//$smsTexterDefinition = new Definition(SmsTexter::class);
//$smsTexterDefinition->addArgument("service.sms.com")
                    ->addArgument("apikey123");
$smsTexterDefinition->setArguments([
    "service.sms.com",
    "apikey123"
]);
$container->setDefinition('texter.sms', $smsTexterDefinition);*/

$container->autowire('texter.sms', SmsTexter::class)
    ->setArguments([
        'service.sms.com',
        'apikey1234'
    ]);

/*
$gmailMailerDefinition = new Definition(GmailMailer::class, [
   'lior@gmail.com',
   '123456'
]);
$container->setDefinition('mailer.gmail', $gmailMailerDefinition);*/

$container->autowire('mailer.gmail', GmailMailer::class)
    ->setArguments([
        '%mailer.gmail_user%',
        '%mailer.gmail_password%'
    ]);

$container->autowire('mailer.smtp', SmtpMailer::class)
    ->setArguments([
    'smtp://localhost',
    'root',
    '123'
]);

$container->autowire('texter.fax', FaxTexter::class);

$container->setAlias('App\Controller\OrderController', 'order_controller')->setPublic(true);
$container->setAlias('App\Database\Database', 'database');
$container->setAlias('App\Mailer\GmailMailer', 'mailer.gmail');
$container->setAlias('App\Mailer\SmtpMailer', 'mailer.smtp');
$container->setAlias('App\Mailer\MailerInterface', 'mailer.gmail');
$container->setAlias('App\Texter\SmsTexter', 'texter.sms');
$container->setAlias('App\Texter\FaxTexter', 'texter.fax');
$container->setAlias('App\Texter\TexterInterface', 'texter.sms');

$container->compile();

$controller = $container->get(OrderController::class);
//$controller = new OrderController($database, $mailer, $texter);

$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
