<?php

namespace Elective\CacheBundle\Validator\Data;

use Exception;

/**
 * Elective\CacheBundle\Validator\Data\ValidatorException
 *
 * @author  Chris Dixon <chris@electivegroup.com>
 * @todo    Move to elective-bundle
 */
class ValidatorException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
