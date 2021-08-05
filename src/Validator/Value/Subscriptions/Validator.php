<?php

namespace Elective\CacheBundle\Validator\Value\Subscriptions;

use Elective\CacheBundle\Validator\Value\ValidatorInterface;
use Elective\CacheBundle\Controller\CacheController;
use Ucc\Exception\Data\InvalidDataValueException;

/**
 * Elective\CacheBundleValidator\Value\Subscriptions\Validator
 *
 * @author Chris Dixon <chris@electivegroup.com>
 */
class Validator implements ValidatorInterface
{
    private $subscriptionPrefix;
    private $cacheSubscriptions;

    public function __construct($subscriptionPrefix, $cacheSubscriptions)
    {
        $this->setSubscriptionPrefix($subscriptionPrefix);
        $this->setCacheSubscriptions($cacheSubscriptions);
    }

    public function setSubscriptionPrefix(?string $subscriptionPrefix): self
    {
        $this->subscriptionPrefix = $subscriptionPrefix;

        return $this;
    }

    public function getCacheSubscriptions(): ?string
    {
        return $this->cacheSubscriptions;
    }

    public function setCacheSubscriptions(?string $cacheSubscriptions): self
    {
        $this->cacheSubscriptions = $cacheSubscriptions;

        return $this;
    }

    public function getSubscriptionPrefix(): ?string
    {
        return $this->subscriptionPrefix;
    }

    public function getSubscriptions(): array
    {
        $cacheSubscriptions = explode(',', $this->getCacheSubscriptions());

        foreach($cacheSubscriptions as &$subscription){
            $subscription =  $this->getSubscriptionPrefix() . $subscription;
        }

        return $cacheSubscriptions;
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
