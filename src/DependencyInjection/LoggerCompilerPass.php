<?php


namespace App\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoggerCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('with_logger');
        var_dump($ids);

        foreach($ids as $id =>$data){
           $definition = $container->getDefinition($id);
           $definition->addMethodCall('setLogger', [new Reference('logger')]);
        }
    }
}