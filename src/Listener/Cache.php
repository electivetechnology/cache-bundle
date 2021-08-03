<?php

namespace Elective\CacheBundle\Listener;

use Elective\CacheBundle\Event\Cache\Clear;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * Elective\CacheBundle\Listener\Cache
 *
 * @author Chris Dixon <chris@electivegroup.com>
 */
class Cache implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return array(
            Clear::NAME => 'onCacheClearEvent',
        );
    }

    public function onCacheClearEvent(Clear $event): Clear
    {
        return $event;
    }
}
