<?php

use App\Controller\OrderController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\DependencyInjection\LoggerCompilerPass;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use App\HasLoggerInterface;
use App\Controller\TestController;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;

require __DIR__ . '/vendor/autoload.php';

$start = microtime(true);

if(file_exists(__DIR__.'/config/container.php')) {
    require_once __DIR__.'/config/container.php';
    $container = new ProjectServiceContainer();
} else {
    $container = new ContainerBuilder();

    $container->registerForAutoconfiguration(HasLoggerInterface::class)->addTag('with_logger');

// Chargement de la configuration des services
//$loader = new PhpFileLoader($container, new FileLocator([__DIR__.'/config']));
//$loader->load('services.php');

    $loader = new YamlFileLoader($container, new FileLocator([__DIR__.'/config']));
    $loader->load('services.yaml');

    $container->addCompilerPass(new LoggerCompilerPass);

    $container->compile();

    $dumper= new PhpDumper($container);

    file_put_contents(__DIR__.'/config/container.php', $dumper->dump());

}


$testController =$container->get(TestController::class);

$controller = $container->get('order_controller');

$duration = microtime(true) - $start;

var_dump("Durée de la construction du container de service : ", $duration * 1000);

$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
