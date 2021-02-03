<?php
namespace Interfaces\Exceptions;

class OperatingSystemNotExists extends \Exception
{
    public $statusCode = 422;

    public function __construct($message = 'Operating system does not exists in db.')
    {
        parent::__construct($message, 422);
    }
}
