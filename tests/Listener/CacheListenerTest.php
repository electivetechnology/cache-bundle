<?php

namespace Elective\CacheBundle\Tests\Listener;

use Elective\CacheBundle\Listener\Cache;
use Elective\CacheBundle\Event\Cache\Clear;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\EventDispatcher\Event;

/**
 * Elective\FormatterBundle\Tests\Listener\Cache
 *
 * @author Chris Dixon <kris@electivegroup.com>
 */
class CacheListenerTest extends TestCase
{
    protected $listener;

    protected function setUp(): void
    {
        $cache = $this->createMock(TagAwareAdapter::class);

        $this->listener = new Cache($cache);
    }

    public function testSetGetCache()
    {
        $cache = $this->createMock(TagAwareAdapter::class);
        $this->assertInstanceOf(Cache::class, $this->listener->setCache($cache));
        $this->assertSame($cache, $this->listener->getCache());
    }

    public function testGetSubscribedEvents()
    {
        $this->assertTrue(is_array($this->listener->getSubscribedEvents()));
        $this->assertTrue(is_array($this->listener::getSubscribedEvents()));
    }

    public function testOnCacheTagEvent()
    {
        $event = $this->createMock(Clear::class);
        $event->method('getModelName')->willReturn('modelName');
        $this->assertSame($event, $this->listener->onCacheClearEvent($event));

//        $this->assertInstanceOf(Cache::class, $this->listener->onCacheClearEvent($event));
    }
}
