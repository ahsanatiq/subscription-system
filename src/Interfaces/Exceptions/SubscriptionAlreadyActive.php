<?php
namespace Interfaces\Exceptions;

class SubscriptionAlreadyActive extends \Exception
{
    public $statusCode = 422;

    public function __construct($message = 'Subscription for this device already exists and active.')
    {
        parent::__construct($message, 422);
    }
}
