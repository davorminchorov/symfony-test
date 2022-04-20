<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class EmailDoesNotExistException extends \Exception
{
    public function __construct($message, $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $code);
    }
}
