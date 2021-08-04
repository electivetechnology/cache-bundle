<?php

namespace Elective\CacheBundle\Services\Api\Google\PubSub;

use Google\Cloud\PubSub\PubSubClient;

/**
 * App\Services\Api\Google\PubSub\Client
 *
 * @author Kris Rybak <kris.rybak@electivegroup.com>
 */
class Client
{
    /**
     * GCP Project Id, i.e. my-project-1pe5b
     *
     * @var string
     */
    private $projectId;

    /**
     * Prefix of the GCP topic name
     *
     * @var string
     */
    private $topicPrefix;

    /**
     * Is client Enabled
     *
     * @var string
     */
    private $isEnabled;

    public function __construct($isEnabled, $projectId, $topicPrefix)
    {
        $this->isEnabled    = $isEnabled;
        $this->projectId    = $projectId;
        $this->topicPrefix  = $topicPrefix;
    }

    public function setProjectId($projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function setTopicPrefix($topicPrefix): self
    {
        $this->topicPrefix = $topicPrefix;

        return $this;
    }

    public function getTopicPrefix()
    {
        return $this->topicPrefix;
    }

    public function setIsEnabled($isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Create Task
     *
     * @param string    $eventName Name of the event, this will be used
     * @param string    $payload   Content of the message
     * @return bool     True if message successfully booked, otherwise false
     */
    public function publishMessage($payload = '', $eventName = 'default'): bool
    {
        // Only communicate with GCP if client is enabled
        if ($this->getIsEnabled() == false) {
            return true;
        }

        // Instantiate the client
        $client = new PubSubClient([
            'projectId' => $this->getProjectId(),
        ]);

        $topic = $client->topic($this->getTopicNameFromEventName($eventName));

        // Send message to pub-sub
        try {
            $topic->publish(['data' => $payload]);
        } catch (ApiException $e) {
            return false;
        }

        return true;
    }

    /**
     * Gets topic name from event name
     */
    public function getTopicNameFromEventName($eventName = 'default'): string
    {
        return $this->getTopicPrefix() . '-' . str_replace('.', '-', $eventName);
    }
}
