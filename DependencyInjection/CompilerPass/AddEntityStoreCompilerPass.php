<?php

namespace SchulIT\LightSamlIdpBundle\DependencyInjection\CompilerPass;

use SchulIT\LightSamlIdpBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddEntityStoreCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container): void {
        $configs = $container->getExtensionConfig('lightsaml_idp');
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $serviceId = 'lightsaml.party.sp_entity_descriptor_store';
        $definition = $container->getDefinition($serviceId);

        $definition->addMethodCall('add', [ new Reference($config['sp_entity_store']) ]);
    }

    private function processConfiguration(ConfigurationInterface $configuration, array $configs): array {
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }
}