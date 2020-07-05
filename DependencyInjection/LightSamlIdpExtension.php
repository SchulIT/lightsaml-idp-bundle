<?php

namespace SchulIT\LightSamlIdpBundle\DependencyInjection;

use SchulIT\LightSamlIdpBundle\RequestStorage\SessionRequestStorage;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class LightSamlIdpExtension extends Extension {

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('lightsaml.route.idp_saml', $config['idp_saml_path']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('profile.yml');
        $loader->load('services.yml');

        $definition = $container->getDefinition(SessionRequestStorage::class);
        $definition->setArgument(1, SessionRequestStorage::DEFAULT_PARAMETERNAME);
        $definition->setArgument(2, isset($config['logger']) ? new Reference($config['logger']) : null);
    }

    public function getAlias() {
        return 'lightsaml_idp';
    }
}