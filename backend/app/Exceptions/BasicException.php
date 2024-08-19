<?php

namespace App\Exceptions;

class BasicException extends \Exception{

    function __construct(
        private $message,
        private $statusCode = 500,
        private $previous = null) {}
}