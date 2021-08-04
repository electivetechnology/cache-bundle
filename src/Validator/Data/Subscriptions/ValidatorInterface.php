<?php

namespace Elective\CacheBundle\Validator\Data\Subscriptions;

/**
 * Elective\CacheBundle\Validator\Data\Subscriptions\ValidatorInterface
 *
 * Interface for strategies to validate Subscriptions Data.
 *
 * @author Kris Rybak <kris@elective.io>
 */
interface ValidatorInterface
{
    public function getReceivedChecks(): array;
}
