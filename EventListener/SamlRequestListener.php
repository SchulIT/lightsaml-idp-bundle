<?php

namespace SchulIT\LightSamlIdpBundle\EventListener;

use SchulIT\LightSamlIdpBundle\RequestStorage\RequestStorageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * This listener stores all income SAML requests for further usage.
 */
class SamlRequestListener implements EventSubscriberInterface {

    private RequestStorageInterface $requestStorage;

    public function __construct(RequestStorageInterface $requestStorage) {
        $this->requestStorage = $requestStorage;
    }

    public function onKernelRequest() {
        $this->requestStorage->save();
    }

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 9] // priority must be higher than the priority of the firewall (currently: 8)
        ];
    }
}