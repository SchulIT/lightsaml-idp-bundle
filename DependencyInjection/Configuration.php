<?php

namespace SchulIT\LightSamlIdpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder('lightsaml_idp');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $root = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $root = $treeBuilder->root('lightsaml_idp');
        }

        $root
            ->children()
                ->scalarNode('idp_saml_path')
                    ->isRequired()
                ->end()
                ->scalarNode('sp_entity_store')
                    ->isRequired()
                ->end()
                ->scalarNode('logger')
                    ->defaultValue('monolog.logger')
                ->end()
            ->end();

        return $treeBuilder;
    }
}