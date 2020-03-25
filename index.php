<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

$databaseDefinition = new Definition(Database::class);

$container->setDefinition('database', $databaseDefinition);
//$container->set('database', new Database());

$smsTexterDefinition = new Definition(SmsTexter::class);
/*$smsTexterDefinition->addArgument("service.sms.com")
                    ->addArgument("apikey123");*/
$smsTexterDefinition->setArguments([
    "service.sms.com",
    "apikey123"
]);
$container->setDefinition('texter.sms', $smsTexterDefinition);

$gmailMailerDefinition = new Definition(GmailMailer::class, [
   'lior@gmail.com',
   '123456'
]);
$container->setDefinition('mailer.gmail', $gmailMailerDefinition);

$controllerDefinition = new Definition(OrderController::class, [
    $container->get('database'),
    $container->get('mailer.gmail'),
    $container->get('texter.sms')
]);
$container->setDefinition('order_controller', $controllerDefinition);

$controller = $container->get('order_controller');
//$controller = new OrderController($database, $mailer, $texter);

$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
