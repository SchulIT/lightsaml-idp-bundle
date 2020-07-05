<?php

namespace SchulIT\LightSamlIdpBundle\Builder\Profile\WebBrowserSso\Idp;

use LightSaml\Build\Container\BuildContainerInterface;
use LightSaml\Builder\Action\ActionBuilderInterface;
use LightSaml\Idp\Builder\Profile\WebBrowserSso\Idp\SsoIdpSendResponseProfileBuilder;

class SsoIdpSendResponseProfileBuilderFactory {
    private $buildContainer;

    public function __construct(BuildContainerInterface $buildContainer) {
        $this->buildContainer = $buildContainer;
    }

    /**
     * @param ActionBuilderInterface[] $assertionBuilders
     * @param string                   $entityId
     * @return SsoIdpSendResponseProfileBuilder
     */
    public function build(array $assertionBuilders, $entityId) {
        return new SsoIdpSendResponseProfileBuilder($this->buildContainer, $assertionBuilders, $entityId);
    }
}