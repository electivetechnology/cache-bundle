<?php

namespace Elective\CacheBundle\Validator\Data\Subscriptions;

/**
 * Elective\CacheBundle\Validator\Data\Subscriptions\ValidatorInterface
 *
 * Interface for strategies to validate Subscriptions Data.
 *
 * @author Chris Dixon <chris@elective.io>
 */
interface ValidatorInterface
{
    public function getReceivedChecks(): array;
}
