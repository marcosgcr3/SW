<?php

namespace es\ucm\fdi\aw\http;

abstract class HttpRequestException extends \RuntimeException implements ResponseStatusCode
{
  public function __construct($message, $code = 0, \Exception $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}