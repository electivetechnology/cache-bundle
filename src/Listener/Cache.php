<?php

namespace Elective\CacheBundle\Listener;

use Elective\CacheBundle\Event\Cache\Clear;
use Elective\FormatterBundle\Event\CacheTagClearableInterface;
use Elective\FormatterBundle\Listener\Cache\TagClearableEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Elective\CacheBundle\Listener\Cache
 *
 * @author Chris Dixon <chris@electivegroup.com>
 */
class Cache implements EventSubscriberInterface
{
    /**
     * @var TagAwareCacheInterface
     */
    private $cache;

    public function __construct(TagAwareCacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get Cache
     *
     * @return TagAwareCacheInterface
     */
    public function getCache(): TagAwareCacheInterface
    {
        return $this->cache;
    }

    /**
     * Set Cache
     *
     * @param $cache TagAwareCacheInterface
     * @return self
     */
    public function setCache(TagAwareCacheInterface $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            Clear::NAME => 'onCacheClearEvent',
        );
    }

    public function onCacheClearEvent(Event $event): Event
    {
        $this->cache->invalidateTags([$event->getModelName()]);

        return $event;
    }
}
