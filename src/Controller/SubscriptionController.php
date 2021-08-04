<?php

namespace Elective\CacheBundle\Controller;

use Elective\CacheBundle\Controller\BaseController;
use Elective\SecurityBundle\Token\TokenDecoderInterface;
use Elective\FormatterBundle\Response\FormatterInterface;
use Elective\FormatterBundle\Request\HandlerInterface;
use Elective\FormatterBundle\Logger\RequestLoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Elective\CacheBundle\Controller\V1\Subscriptions\SubscriptionController
 *
 * This SubscriptionController class provides method to quickly output data
 * in the desired format using response formatter. In addition to BaseController
 * it provides configuration and helpers for Pub/Sub integration
 *
 * @author Kris Rybak <kris@elective.io>
 */
class SubscriptionController extends BaseController
{
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

        parent::__construct(
            $formatter,
            $handler,
            $tokenDecoder,
            $logger,
            $dispatcher
        );
    }
}
