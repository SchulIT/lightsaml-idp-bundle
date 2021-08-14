<?php

namespace SchulIT\LightSamlIdpBundle\RequestStorage;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionRequestStorage implements RequestStorageInterface {
    private $parameterName;
    private $requestStack;

    private $logger;

    const DEFAULT_PARAMETERNAME = 'SAMLRequest';

    public function __construct(RequestStack $requestStack, $parameterName = self::DEFAULT_PARAMETERNAME, LoggerInterface $logger = null) {
        $this->parameterName = $parameterName;
        $this->requestStack = $requestStack;

        $this->logger = $logger ?? new NullLogger();
    }

    public function save() {
        $request = $this->getMainRequest($this->requestStack);
        $session = $request->getSession();

        if($session === null) {
            $this->logger->debug('Do not save any SAML request as no session is associated to the current request');
            return;
        }

        if($request->isMethod('POST') !== true) {
            $this->logger->debug('No POST request, thus no potential SAML request');
            return;
        }

        if($request->request->has($this->parameterName) !== true) {
            $this->logger->debug('No SAML request found');
            return;
        }

        $this->logger->debug('SAML request found');

        $samlRequest = $request->request->get($this->parameterName);
        $session->set($this->parameterName, $samlRequest);

        $this->logger->debug('SAML request stored in current session');
    }

    public function load() {
        $request = $this->getMainRequest($this->requestStack);

        if($request->query->has($this->parameterName)) {
            // Handle current HTTP-Redirect Binding
            return;
        }

        $session = $request->getSession();

        if($session === null) {
            $this->logger->debug('Do not save any SAML request as no session is associated to the current request');
            return;
        }

        if($request->isMethod('POST') && $request->request->has($this->parameterName)) {
            $this->logger->debug('Do not fetch SAML request from database as another SAML request is incoming');
            return;
        }

        if($session->has($this->parameterName) !== true) {
            $this->logger->debug('No SAML request found in session');
            return;
        }

        $this->logger->debug('SAML request found');

        $samlRequest = $session->get($this->parameterName);
        $request->setMethod('POST');
        $request->request->set($this->parameterName, $samlRequest);

        $this->logger->debug('SAML request stored in current request');
    }

    public function clear() {
        $request = $this->getMainRequest($this->requestStack);
        $session = $request->getSession();

        if($session === null) {
            $this->logger->debug('Do not save any SAML request as no session is associated to the current request');
            return;
        }

        if($session->has($this->parameterName) === true) {
            $session->remove($this->parameterName);
            $this->logger->debug('SAML request removed from session');
            return;
        }
    }

    public function has(): bool {
        $request = $this->getMainRequest($this->requestStack);

        if($request->query->has($this->parameterName)) {
            // HTTP-Redirect Binding
            return true;
        }

        // Query previous HTTP-POST Bindings
        $session = $request->getSession();

        if($session === null) {
            $this->logger->debug('Do not save any SAML request as no session is associated to the current request');
            return false;
        }

        return $session->has($this->parameterName);
    }

    protected function getMainRequest(RequestStack $requestStack): Request {
        if(method_exists($requestStack, 'getMainRequest')) {
            return $requestStack->getMainRequest();
        }

        return $requestStack->getMasterRequest();
    }
}