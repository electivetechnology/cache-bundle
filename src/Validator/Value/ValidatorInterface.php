<?php

namespace Elective\CacheBundle\Validator\Value;

use Ucc\Exception\Data\InvalidDataValueException;

/**
 *Elective\CacheBundle\Validator\Value\ValidatorInterface;
 *
 * @author Chris Dixon <chris@electivegroup.com>
 */
interface ValidatorInterface
{
    /**
     * Checks if give value is valid
     *
     * @param   $value mixed  Value to check
     * @return  mixed
     * @throws  InvalidDataValueException
     */
    public function isValidValue($value);
}
