<?php

namespace SchulIT\LightSamlIdpBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ReplaceOwnEntityProviderCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container): void {
        $definition = $container->getDefinition('lightsaml.own.entity_descriptor_provider');
        $definition
            ->setPublic(true)
            ->setArgument(0, '%lightsaml.own.entity_id%')
            ->setArgument(1, new Reference('router'))
            ->setArgument(2, null)
            ->setArgument(3, '%lightsaml.route.idp_saml%')
            ->setArgument(4, new Reference('lightsaml.own.credential_store'));
    }
}