<?php

namespace Elective\CacheBundle\Validator\Data;

use Elective\CacheBundle\Validator\Data\ValidatorException;
use Ucc\Data\Validator\ValidatorInterface;
use Ucc\Exception\Data\InvalidDataValueException;

/**
 * Elective\CacheBundle\Validator\Data\Validator
 *
 * @author Chris Dixon <chris@elective.io>
 */
abstract class Validator
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var array
     */
    protected $parameters;

    public function __construct(ValidatorInterface $validator, $parameters = array())
    {
        $this->setValidator($validator);
        $this->setParameters($parameters);
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function getParameter($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }

        return null;
    }

    public function addParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function setParameters($parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->addParameter($key, $value);
        }

        return $this;
    }

    /**
     * Validates data
     *
     * @param $data array
     * @param $type string
     * @throws ValidatorException
     */
    public function validate($data = array(), string $type = '')
    {
        $checkMethod = 'get' . ucfirst($type) . 'Checks';

        if (!is_callable(array($this, $checkMethod))) {
            throw new ValidatorException(
                "Check for $type is not defined. Have you forgotten to set up a "
                . $checkMethod . " check in your validator? Tried to call "
                . $checkMethod . " method in " . get_class($this)
                . " class but the method was not defined."
            );
        }

        $this->validator
            ->clearInputData() // Clear existing input
            ->clearSafeData() // Clear existing values
            ->clearChecks() // Clear existing checks
            ->setInputData((array) $data)->setChecks($this->$checkMethod());

        if (!$this->validator->validate()) {
            throw new ValidatorException($this->validator->getError(), $this->validator->getErrorCode());
        }

        return (object) $this->validator->getSafeData();
    }


    public static function checkIsValidDateTimeString($value, array $requirements = array())
    {
        if ($value == '' || $value == []) {
            return null;
        }
        // Try timestamp
        if (is_numeric($value)) {
            $dateTime = (new \DateTime())->setTimestamp($value);

            $year = (int) $dateTime->format('Y');
            if ($year > 9999) {
                throw new InvalidDataValueException("value is not valid Unix timestamp");
            }
        } elseif ($value) {
            try {
                $dateTime = new \DateTime($value);
            } catch (\Exception $e) {
                throw new InvalidDataValueException(
                    "value is not valid format of date time. Required format: Y-m-d H:i:s or a timestamp"
                );
            }
        } elseif (isset($requirements['opt']) && !$requirements['opt']) {
            throw new InvalidDataValueException(
                "value is not valid format of date time. Required format: Y-m-d H:i:s or a timestamp"
            );
        }

        if (isset($requirements['entity']) && $requirements['entity'] && isset($dateTime)) {
            return $dateTime;
        }

        return $value;
    }
}
