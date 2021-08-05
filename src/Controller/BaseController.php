<?php

namespace Elective\CacheBundle\Controller;

use Elective\SecurityBundle\Token\TokenDecoderInterface;
use Elective\FormatterBundle\Traits\Outputable;
use Elective\FormatterBundle\Traits\Loggable;
use Elective\FormatterBundle\Response\FormatterInterface;
use Elective\FormatterBundle\Request\HandlerInterface;
use Elective\FormatterBundle\Logger\RequestLoggerInterface;
use Symfony\Component\Security\Core\Exception\{
    AccessDeniedException
};
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Elective\FormatterBundle\Controller\BaseController as AbstractController;
use Elective\FormatterBundle\Parsers\Csv as CsvParser;

/**
 * Elective\CacheBundle\Controller\BaseController
 *
 * This BaseController class provides method to quickly output data
 * in the desired format using response formatter.
 *
 * @author Chris Dixon <chris@electivegroup.com>
 */
class BaseController extends AbstractController
{
    use Outputable;
    use Loggable;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(
        FormatterInterface $formatter,
        HandlerInterface $handler,
        TokenDecoderInterface $tokenDecoder,
        RequestLoggerInterface $logger,
        EventDispatcherInterface $dispatcher
    ) {
        $this->formatter    = $formatter;
        $this->handler      = $handler;
        $this->tokenDecoder = $tokenDecoder;
        $this->setLogger($logger);
        $this->setDispatcher($dispatcher);
    }

    public function getTokenDecoder(): TokenDecoderInterface
    {
        return $this->tokenDecoder;
    }

    /**
     * Get dispatcher
     *
     * @return EventDispatcherInterface
     */
    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher;
    }

    /**
     * Set dispatcher
     *
     * @param $dispatcher EventDispatcherInterface
     * @return self
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): self
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }
}
