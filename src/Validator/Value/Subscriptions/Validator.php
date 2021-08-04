<?php

namespace Elective\CacheBundle\Validator\Value\Subscriptions;

use Elective\CacheBundle\Validator\Value\ValidatorInterface;
use Elective\CacheBundle\Controller\CacheController;
use Ucc\Exception\Data\InvalidDataValueException;

/**
 * Elective\CacheBundleValidator\Value\Subscriptions\Validator
 *
 * @author Kris Rybak <kris.rybak@electivegroup.com>
 */
class Validator implements ValidatorInterface
{
    private $subscriptionPrefix;

    public function __construct($subscriptionPrefix)
    {
        $this->setSubscriptionPrefix($subscriptionPrefix);
    }

    public function setSubscriptionPrefix(?string $subscriptionPrefix): self
    {
        $this->subscriptionPrefix = $subscriptionPrefix;

        return $this;
    }

    public function getSubscriptionPrefix(): ?string
    {
        return $this->subscriptionPrefix;
    }

    public function getSubscriptions(): array
    {
        return array(
            $this->getSubscriptionPrefix() . CacheController::SUBSCRIPTION_NAME_UPDATED,
        );
    }

    public function isValidValue($value)
    {
        return $this->isValidSubscription($value);
    }

    public function isValidSubscription($value)
    {
        if (!in_array($value, $this->getSubscriptions())) {
            throw new InvalidDataValueException('value must be one of: ' . implode(',', $this->getSubscriptions()));
        }

        return $value;
    }
}
