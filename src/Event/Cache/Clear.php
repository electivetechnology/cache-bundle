<?php

namespace Elective\CacheBundle\Event\Cache;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * App\Event\Cache\Clear
 *
 * @author Chris Dixon <chris@electivegroup.com>
 *
 * The cache.clear event is dispatched each time new cache is clear
 * in the system.
 */
class Clear extends Event
{
    public const NAME = 'cache.clear';

    private $modelName;
    private $requestStack;

    public function __construct(string $modelName, RequestStack $requestStack)
    {
        $this->modelName   = $modelName;
        $this->requestStack = $requestStack;
    }

    public function getModelName(): string
    {
        return $this->modelName;
    }

    public function setModelName(?string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }

    public function setRequestStack(?RequestStack $requestStack): self
    {
        $this->requestStack = $requestStack;

        return $this;
    }
}
