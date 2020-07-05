<?php

namespace SchulIT\LightSamlIdpBundle;

use SchulIT\LightSamlIdpBundle\DependencyInjection\CompilerPass\AddEntityStoreCompilerPass;
use SchulIT\LightSamlIdpBundle\DependencyInjection\CompilerPass\ReplaceOwnEntityProviderCompilerPass;
use SchulIT\LightSamlIdpBundle\DependencyInjection\LightSamlIdpExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LightSamlIdpBundle extends Bundle {

    public function build(ContainerBuilder $container) {
        parent::build($container);

        $container->addCompilerPass(new ReplaceOwnEntityProviderCompilerPass());
        $container->addCompilerPass(new AddEntityStoreCompilerPass());
    }

    public function getContainerExtension() {
        return new LightSamlIdpExtension();
    }
}