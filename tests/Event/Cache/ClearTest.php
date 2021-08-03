<?php

namespace Elective\CacheBundle\Tests\Event\Cache;

use Elective\CacheBundle\Event\Cache\Clear;
use Symfony\Component\HttpFoundation\RequestStack;
use PHPUnit\Framework\TestCase;

class ClearTest extends TestCase
{
    public function createEvent($modelName = ''): Clear
    {
        $requestStack   = $this->createMock(RequestStack::class);
        $event = new Clear($modelName, $requestStack);

        return $event;
    }

    public function modelNamesProvider()
    {
        return array(
            array('candidate'),
            array('label'),
            array('organisation'),
        );
    }

    /**
     * @dataProvider modelNamesProvider
     */
    public function testGetModelNames($modelNames)
    {
        $event = $this->createEvent($modelNames);
        $this->assertEquals($modelNames, $event->getModelName());
    }
}
