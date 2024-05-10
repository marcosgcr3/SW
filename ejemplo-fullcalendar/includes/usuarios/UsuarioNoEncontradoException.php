<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\http\ResponseStatusCode;

class UsuarioNoEncontradoException extends \Exception implements ResponseStatusCode
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
  
    public function getCode()
    {
        return 404;
    }
}