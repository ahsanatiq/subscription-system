<?php
namespace Interfaces\Exceptions;

class InvalidJwtTokenException extends \Exception
{
    public $statusCode = 400;

    public function __construct($e)
    {
        $message = $e->getMessage() ? $e->getMessage() : 'Invalid JWT Token';
        parent::__construct($message, 400);
    }
}
