<?php

namespace Elective\CacheBundle\Services\Api\Google\PubSub;

use Elective\FormatterBundle\Parsers\Json;

/**
 * App\Services\Api\Google\PubSub\Message
 *
 * A wrapper class that provides common interfaces for PubSub messages
 * @author Chris Dixon <chris@electivegroup.com>
 */
class Message
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @var string
     */
    private $rawData;

    /**
     * @var object
     */
    private $data;

    /**
     * @var string
     */
    private $messageId;

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(?array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            $this->addAttribute($key, $value);
        }

        return $this;
    }

    public function addAttribute($key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function getAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return null;
    }

    public function setRawData(?string $rawData): self
    {
        $this->rawData = $rawData;

        return $this;
    }

    public function getRawData(): ?string
    {
        return $this->rawData;
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setMessageId(?string $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function fromObject($data, $isObject = false): self
    {
        if (isset($data->attributes)) {
            $attributes = (array) $data->attributes;

            foreach ($attributes as $key => $value) {
                $this->addAttribute($key, $value);
            }
        }

        if (isset($data->data)) {
            // Set raw data
            $this->setRawData($data->data);

            // Decode and set data
            $decoded = base64_decode($data->data);

            if ($isObject) {
                $decoded = JSON::parse($decoded);
            }

            $this->setData($decoded);
        }

        if (isset($data->messageId)) {
            $this->setMessageId($data->messageId);
        }

        return $this;
    }

    public function get($key)
    {
        if (!is_object($this->getData())) {
            throw new \Exception("Can only retrieve data of object type");
        }

        if (isset($this->getData()->$key)) {
            return $this->getData()->$key;
        }

        return null;
    }
}
