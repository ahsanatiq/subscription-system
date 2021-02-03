<?php
namespace Interfaces\Exceptions;

class UnauthorizedException extends \Exception
{
    public function __construct($message = 'Unauthorized')
    {
        parent::__construct($message, 401);
    }
}
