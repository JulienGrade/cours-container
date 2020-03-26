<?php

use App\Controller\OrderController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\DependencyInjection\LoggerCompilerPass;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

// Chargement de la configuration des services
//$loader = new PhpFileLoader($container, new FileLocator([__DIR__.'/config']));
//$loader->load('services.php');

$loader = new YamlFileLoader($container, new FileLocator([__DIR__.'/config']));
$loader->load('services.yaml');

$container->addCompilerPass(new LoggerCompilerPass);

$container->compile();

$controller = $container->get(OrderController::class);

$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
