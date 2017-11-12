<?php
namespace swibl\core;

abstract class ServiceResponse implements \JsonSerializable {
    
    const SUCCESS = true;
    const FAIL = false;

    protected $code = null;
    protected $message = null;
    protected $data = null;
    protected $errors = array();
    
    public function __construct($code, $message)
    {
        $this->setCode($code);
        $this->setMessage($message);
        $this->data = $data;
    }
    
    
    /**
     * @return the $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return the $message
     */
    public function getMessage()
    {
        return $this->message;
    }
    
  
    /**
     * @param field_type $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param field_type $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    abstract public function getData();
    
    public function addError(Error $error) {
        $this->errors[] = $error;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function jsonSerialize() {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'errors' => $this->errors,
            'data' => $this->data
        ];
    }
}