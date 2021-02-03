<?php
namespace Interfaces\Exceptions;

class SubscriptionNotFoundException extends \Exception
{
    public $statusCode = 400;

    public function __construct()
    {
        parent::__construct("Subscription not found.", 400);
    }
}
