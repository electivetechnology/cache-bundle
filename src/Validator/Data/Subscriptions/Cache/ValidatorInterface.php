<?php

namespace Elective\CacheBundle\Validator\Data\Subscriptions\Cache;

/**
 * Elective\CacheBundle\Validator\Data\Subscriptions\Cache\ValidatorInterface
 *
 * Interface for strategies to validate Subscriptions Data.
 *
 * @author Chris Dixo  <chris@elective.io>
 */
interface ValidatorInterface
{
    public function getUpdatedChecks(): array;
}
