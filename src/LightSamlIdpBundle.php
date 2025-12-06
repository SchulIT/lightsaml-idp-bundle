<?php

namespace SchulIT\LightSamlIdpBundle;

use SchulIT\LightSamlIdpBundle\DependencyInjection\CompilerPass\AddEntityStoreCompilerPass;
use SchulIT\LightSamlIdpBundle\DependencyInjection\CompilerPass\ReplaceOwnEntityProviderCompilerPass;
use SchulIT\LightSamlIdpBundle\RequestStorage\SessionRequestStorage;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class LightSamlIdpBundle extends AbstractBundle {

    public function configure(DefinitionConfigurator $definition): void {
        $definition->rootNode()
            ->children()
                ->scalarNode('idp_saml_path')->isRequired()->end()
                ->scalarNode('sp_entity_store')->isRequired()->end()
                ->scalarNode('logger')->defaultValue('monolog.logger')->end()
            ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void {
        $builder->setParameter('lightsaml.route.idp_saml', $config['idp_saml_path']);
        $builder->setParameter('lightsaml.sp_entity_store', $config['sp_entity_store']);

        $loader = new YamlFileLoader($builder, new FileLocator(__DIR__ . '/../config'));
        $loader->load('profile.yml');
        $loader->load('services.yml');

        $definition = $builder->getDefinition(SessionRequestStorage::class);
        $definition->setArgument(1, SessionRequestStorage::DEFAULT_PARAMETERNAME);
        $definition->setArgument(2, isset($config['logger']) ? new Reference($config['logger']) : null);
    }

    public function build(ContainerBuilder $container): void {
        parent::build($container);

        $container->addCompilerPass(new ReplaceOwnEntityProviderCompilerPass());
        $container->addCompilerPass(new AddEntityStoreCompilerPass());
    }
}