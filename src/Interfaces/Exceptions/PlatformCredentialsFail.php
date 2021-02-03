<?php
namespace Interfaces\Exceptions;

class PlatformCredentialsFail extends \Exception
{
    public $statusCode = 401;

    public function __construct($message = 'Platform credentials failure.')
    {
        parent::__construct($message, 401);
    }
}
