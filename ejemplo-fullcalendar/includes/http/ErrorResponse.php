<?php

namespace es\ucm\fdi\aw\http;

/**
 * RFC 7807 - Error Response
 */
class ErrorResponse implements \JsonSerializable
{
        
    public static function fromException(\Throwable $e)
    {
        $message = $e->getMessage();
        $statusCode = 500;
        if ($e instanceof ResponseStatusCode) {
            $statusCode = $e->getStatusCode();
        }
        
        return new ErrorResponse($message, $message, $statusCode);
    }
    
    
    /**
     * @var string $title contains a short, human-readable title for the general error type; the title should not change for given types.
     */
    private $title;

    /**
     * @var string $detail contains a human-readable description of the specific error.
     */
    private $detail;
    
    /**
     * @var int $status contains the the HTTP status code; this is so that all information is in one place, but also to correct for changes in the status code due to the usage of proxy servers. The status member, if present, is only advisory as generators MUST use the same status code in the actual HTTP response to assure that generic HTTP software that does not understand this format still behaves correctly. 
     */
    private $status;
    
    /**
     * @var string|null $type contains a URL to a document describing the error condition (optional, and "about:blank" is assumed if none is provided; should resolve to a human-readable document).
     */
    private $type;

    /**
     * @var string|null $instance is optional key may be present, with a unique URI for the specific error; this will often point to an error log for that specific response.
     */
    private $instance;
    
    private function __construct(string $title, string $detail, int $status, string $type = null, string $instance = null)
    {
        $this->title = $title;
        $this->detail = $detail;
        $this->status = $status;
        $this->type = $type;
        $this->instance = $instance;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
    
    public function getDetail()
    {
        return $this->detail;
    }
    
    public function setDetail(string $detail)
    {
        $this->detail = $detail;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function setStatus(int $status)
    {
        $this->status = $status;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function setType(string $type)
    {
        $this->type = $type;
    }
    
    public function getInstance()
    {
        return $this->instance;
    }
    
    public function setInstance(string $instance)
    {
        $this->instance = $instance;
    }
  
    public function jsonSerialize()
    {
        $o = new \stdClass();
        $o->title = $this->title;
        $o->detail = $this->detail;
        $o->status = $this->status;
        if ($this->type) {
            $o->type = $this->type;
        }
        if ($this->instance) {
            $o->instance = $this->instance;
        }
        return $o;
    }
}