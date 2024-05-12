<?php

namespace es\ucm\fdi\aw\http;

class MetodoNoSoportadoException extends HttpRequestException implements ResponseStatusCode
{
  public function __construct($message, $code = 0, \Exception $previous = null) {
    parent::__construct($message, $code, $previous);
  }
   
  public function getStatusCode()
  {
      return 405;
  }
}