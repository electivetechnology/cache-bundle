<?php

namespace Elective\CacheBundle\Controller;

use Elective\CacheBundle\Event\Cache\Clear as ClearEvent;
use Elective\CacheBundle\Validator\Data\Subscriptions\ValidatorInterface;
use Elective\CacheBundle\Validator\Data\ValidatorException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Elective\FormatterBundle\Controller\PreFlightTrait;

/**
 * Elective\CacheBundle\Controller\V1\Subscriptions\Acl\AclController
 *
 * @author Chris Dixon
 * @Route("/v1/subscriptions/cache")
 */
class CacheController extends SubscriptionController
{
    use PreFlightTrait;

    public const SUBSCRIPTION_NAME_UPDATED = '-generic-entity-updated-generic';

    /**
     * @Route("/clear", methods={"POST"})
     */
    public function updated(
        ValidatorInterface $subscriptionDataValidator,
        RequestStack $requestStack
    ): Response {
        $this->getLogger()->info('Started POST: /v1/subscriptions/acl/cache/updated');

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

        // Check if Channel Id is present
        if (!isset($messageData->modelName)) {
            // Ack message as we can not deal with it and we don't want this to clutter Pub/Sub
            // At this stage we probably should also log this somewhere
            $this->getLogger()->error('Pub/Sub message did not contain id');

            return $this->output(null, Response::HTTP_ACCEPTED);
        }

        $this->getLogger()->info('Preparing ClearEvent');

        // Prepare event
        $event = new ClearEvent(
            $requestStack,
            $messageData->modelName
        );

        // Dispatch Event informing subscribers
        $this->getLogger()->info('Dispatching UpdatedEvent');
        $this->getDispatcher()->dispatch(ClearEvent::NAME, $event);

        $this
            ->getLogger()
            ->info('
                Finished POST: /v1/subscriptions/acl/cache/updated with status: '
                . Response::HTTP_NO_CONTENT);

        return $this->output(null, Response::HTTP_NO_CONTENT);
    }
}
