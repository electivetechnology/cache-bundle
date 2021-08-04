<?php

namespace Elective\CacheBundle\Validator\Value\Subscriptions\Message;

use Elective\CacheBundle\Validator\Value\ValidatorInterface;
use Elective\CacheBundle\Services\Api\Google\PubSub\Message;
use Ucc\Exception\Data\InvalidDataValueException;

/**
 * Elective\CacheBundleValidator\Value\Subscriptions\Message\Validator
 *
 * @author Kris Rybak <kris.rybak@electivegroup.com>
 */
class Validator implements ValidatorInterface
{
    public function isValidValue($value, $requirements = array())
    {
        return $this->isValidMessage($value, $requirements);
    }

    public function isValidMessage($value, $requirements = array())
    {
        if (!isset($value->messageId)) {
            throw new InvalidDataValueException('value is missing messageId property');
        }

        if (!isset($value->data)) {
            throw new InvalidDataValueException('value is missing data property');
        }

        if (isset($requirements['entity']) && ($requirements['entity'] == true)) {
            $object = false;

            if (isset($requirements['data-object']) && ($requirements['data-object'] == true)) {
                $object = true;
            }

            $message = new Message();
            $message->fromObject($value, $object);

            return $message;
        }

        return $value;
    }
}
