<?php

namespace SchoolIT\LightSamlIdpBundle;

use SchoolIT\LightSamlIdpBundle\DependencyInjection\CompilerPass\AddEntityStoreCompilerPass;
use SchoolIT\LightSamlIdpBundle\DependencyInjection\CompilerPass\ReplaceOwnEntityProviderCompilerPass;
use SchoolIT\LightSamlIdpBundle\DependencyInjection\LightSamlIdpExtension;
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