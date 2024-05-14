<?php

namespace es\ucm\fdi\aw\citas;

use es\ucm\fdi\aw\http\ResponseStatusCode;

class CitaNoEncontradoException extends \RuntimeException implements ResponseStatusCode
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
      
    public function getStatusCode()
    {
        return 404;
    }
}