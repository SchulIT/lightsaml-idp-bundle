<?php

namespace SchoolIT\LightSamlIdpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('lightsaml_idp');

        $root
            ->children()
                ->scalarNode('idp_saml_path')
                    ->isRequired()
                ->end()
                ->scalarNode('sp_entity_store')
                    ->isRequired()
                ->end()
                ->scalarNode('logger')->end()
            ->end();

        return $treeBuilder;
    }
}