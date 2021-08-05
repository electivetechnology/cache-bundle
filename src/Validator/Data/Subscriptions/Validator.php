<?php

namespace Elective\CacheBundle\Validator\Data\Subscriptions;

use Elective\CacheBundle\Validator\Data\Subscriptions\ValidatorInterface as CreatedValidatorInterface;
use Elective\CacheBundle\Validator\Value\Subscriptions\Validator as SubscriptionValueValidator;
use Elective\CacheBundle\Validator\Value\Subscriptions\Message\Validator as MessageValueValidator;
use Elective\CacheBundle\Validator\Data\Validator as BaseValidator;
use Ucc\Data\Validator\ValidatorInterface;

/**
 * Elective\CacheBundle\Validator\Data\Subscriptions\Validator;
 *
 * @author Chris Dixon <chris@electivegroup.com>
 */
class Validator extends BaseValidator implements CreatedValidatorInterface
{
    public const VALIDATOR_MESSAGE_MISSING         = 400255001;
    public const VALIDATOR_SUBSCRIPTION_MISSING    = 400255002;
    public const VALIDATOR_MESSAGE_INVALID         = 400255003;
    public const VALIDATOR_SUBSCRIPTION_INVALID    = 400255004;

    /**
     * @var SubscriptionValueValidator
     */
    private $subscriptionValueValidator;

    /**
     * @var MessageValueValidator
     */
    private $messageValueValidator;

    public function __construct(
        ValidatorInterface $validator,
        SubscriptionValueValidator $subscriptionValueValidator,
        MessageValueValidator $messageValueValidator
    ) {
        $this->setValidator($validator);
        $this->setSubscriptionValueValidator($subscriptionValueValidator);
        $this->setMessageValueValidator($messageValueValidator);
    }

    /**
     * Set SubscriptionValueValidator
     */
    public function setSubscriptionValueValidator($subscriptionValueValidator): self
    {
        $this->subscriptionValueValidator = $subscriptionValueValidator;

        return $this;
    }

    /**
     * Get SubscriptionValueValidator
     */
    public function getSubscriptionValueValidator(): SubscriptionValueValidator
    {
        return $this->subscriptionValueValidator;
    }

    /**
     * Set MessageValueValidator
     */
    public function setMessageValueValidator($messageValueValidator): self
    {
        $this->messageValueValidator = $messageValueValidator;

        return $this;
    }

    /**
     * Get MessageValueValidator
     */
    public function getMessageValueValidator(): MessageValueValidator
    {
        return $this->messageValueValidator;
    }

    public function getReceivedChecks(): array
    {
        return array(
            'message'               => array(
                'type'              => 'custom',
                'class'             => $this->getMessageValueValidator(),
                'method'            => 'isValidValue',
                'opt'               => false,
                'entity'            => true,
                'data-object'       => true,
                'error-code-opt'    => self::VALIDATOR_MESSAGE_MISSING,
                'error-code-value'  => self::VALIDATOR_MESSAGE_INVALID,
            ),
            'subscription'          => array(
                'type'              => 'custom',
                'class'             => $this->getSubscriptionValueValidator(),
                'method'            => 'isValidValue',
                'opt'               => false,
                'error-code-opt'    => self::VALIDATOR_SUBSCRIPTION_MISSING,
                'error-code-value'  => self::VALIDATOR_SUBSCRIPTION_INVALID,
            ),
        );
    }
}
