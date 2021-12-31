<?php

namespace SchulIT\LightSamlIdpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder {
        $treeBuilder = new TreeBuilder('lightsaml_idp');
        $root = $treeBuilder->getRootNode();

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