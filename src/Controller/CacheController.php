<?php

namespace Elective\CacheBundle\Controller;

use Elective\CacheBundle\Event\Cache\Clear as ClearEvent;
use Elective\CacheBundle\Validator\Data\Subscriptions\Cache\ValidatorInterface as CacheInterface;
use Elective\CacheBundle\Validator\Data\ValidatorException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Elective\FormatterBundle\Controller\PreFlightTrait;

/**
 * Elective\CacheBundle\Controller\Subscriptions\CacheController
 *
 * @author Chris Dixon
 * @Route("/v1/subscriptions/cache")
 */
class CacheController extends BaseController
{
    use PreFlightTrait;
    
    /**
     * @Route("/clear", methods={"POST"})
     */
    public function updated(
        CacheInterface $subscriptionDataValidator,
        RequestStack $requestStack
    ): Response {

        $this->getLogger()->info('Started POST: /subscriptions/cache/updated');

        // Validate data
        try {
            $this->getLogger()->info('Received data from Pub/Sub: ' . serialize($this->getPostData()));
            $safeData = $subscriptionDataValidator->validate($this->getPostData(), 'updated');
        } catch (ValidatorException $e) {
            $this->getLogger()->info('Received invalid data from Pub/Sub: ' . $e->getMessage());
            $this->exception($e->getMessage(), Response::HTTP_BAD_REQUEST, $e->getCode());
        }
        $this->getLogger()->info('Validated data: ' . serialize($safeData));

        $messageData = $safeData->message->getData();

        // Check if modelName is present
        if (!isset($messageData->modelName)) {
            $this->getLogger()->error('Pub/Sub message did not contain modelName');

            return $this->output(null, Response::HTTP_ACCEPTED);
        }

        // Check if organisation is present
        if (!isset($messageData->organisation)) {
            $this->getLogger()->error('Pub/Sub message did not contain organisation');

            return $this->output(null, Response::HTTP_ACCEPTED);
        }

        $this->getLogger()->info('Preparing ClearEvent');

        // Prepare event
        $event = new ClearEvent(
            (isset($messageData->id)) ? $messageData->id : '',
            $messageData->modelName,
            $messageData->organisation,
            $requestStack
        );

        // Dispatch Event informing subscribers
        $this->getLogger()->info('Dispatching UpdatedEvent');
        $this->getDispatcher()->dispatch(ClearEvent::NAME, $event);

        $this
            ->getLogger()
            ->info('
                Finished POST: /subscriptions/cache/updated with status: '
                . Response::HTTP_NO_CONTENT);

        return $this->output(null, Response::HTTP_NO_CONTENT);
    }
}
