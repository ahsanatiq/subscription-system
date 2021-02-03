<?php
namespace Interfaces\Exceptions;

class UnexpectedException extends \Exception
{
    public function __construct()
    {
        $message = 'Whoops, something went wrong';
        parent::__construct($message, 500);
    }
}
