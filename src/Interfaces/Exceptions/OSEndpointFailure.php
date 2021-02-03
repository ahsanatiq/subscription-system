<?php
namespace Interfaces\Exceptions;

class OSEndpointFailure extends \Exception
{
    public $statusCode = 400;

    public function __construct($message = 'Error from Operating system endpoint.')
    {
        parent::__construct($message, 400);
    }
}
