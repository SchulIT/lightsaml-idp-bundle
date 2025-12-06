<?php

namespace SchulIT\LightSamlIdpBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddEntityStoreCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container): void {
        $serviceId = 'lightsaml.party.sp_entity_descriptor_store';
        $definition = $container->getDefinition($serviceId);

        $definition->addMethodCall('add', [ new Reference($container->getParameter('sp_entity_store')) ]);
    }
}