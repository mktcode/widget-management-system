<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 16.03.16
 * Time: 15:16
 */

namespace App\Service;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContentTypeCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $contentTypes = $container->findTaggedServiceIds('content_type');
        $config = $container->findDefinition('config');
        $database = $container->findDefinition('database');
        $routing = $container->findDefinition('routing');
        $translator = $container->findDefinition('translator');

        foreach ($contentTypes as $id => $tags) {
            $definition = $container->findDefinition($id);
            $definition->addMethodCall('setServices', [$config, $database, $routing, $translator]);
        }
    }
}