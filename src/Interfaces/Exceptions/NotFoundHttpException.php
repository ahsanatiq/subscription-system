<?php
namespace Interfaces\Exceptions;

class NotFoundHttpException extends \Exception
{
    public $statusCode = 404;

    public function __construct()
    {
        parent::__construct("Resource not found.", 404);
    }
}
