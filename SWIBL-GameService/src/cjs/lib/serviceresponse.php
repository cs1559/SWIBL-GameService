<?php
namespace cjs\lib;

class ServiceResponse {
    
    const SUCCESS = true;
    const FAIL = false;

    var $code = null;
    var $message = null;
    var $data = null;
    var $errors = array();
    
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

    public function setData($content) {
        $this->data = $content;
    }
    public function getData() {
        return $this->data;
    }
    
    public function addError(Error $error) {
        $this->errors[] = $error;
    }
    
    public function getErrors() {
        return $this->errors;
    }
}