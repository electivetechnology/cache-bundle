<?php

namespace Elective\CacheBundle\Validator\Data;

use Exception;

/**
 * Elective\CacheBundle\Validator\Data\ValidatorException
 *
 * @author  Kris Rybak <kris.rybak@electivegroup.com>
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
