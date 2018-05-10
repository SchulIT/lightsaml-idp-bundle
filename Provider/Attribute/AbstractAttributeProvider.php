<?php

namespace SchoolIT\LightSamlIdpBundle\Provider\Attribute;

use LightSaml\Context\Profile\AssertionContext;
use LightSaml\Context\Profile\ProfileContext;
use LightSaml\Provider\Attribute\AttributeValueProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class AbstractAttributeProvider implements AttributeValueProviderInterface {

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage) {
        $this->tokenStorage = $tokenStorage;
    }

    protected abstract function getValuesForUser(UserInterface $user, $entityId);

    public final function getValues(AssertionContext $context) {
        /** @var ProfileContext $profileContext */
        $profileContext = $context->getParent();

        if(!$profileContext instanceof ProfileContext) {
            throw new \RuntimeException(
                sprintf('Parent context must be of type "%s" ("%s" given)', ProfileContext::class, get_class($profileContext))
            );
        }

        /*
         * You should create a list of attributes here based on the submitting
         * Service Provider. Its entityID can be retried using:
         */
        $message = $profileContext->getInboundMessage();
        $entityId = $message->getIssuer()->getValue();

        $token = $this->tokenStorage->getToken();
        /** @var UserInterface $user */
        $user = $token->getUser();

        return $this->getValuesForUser($user, $entityId);
    }
}