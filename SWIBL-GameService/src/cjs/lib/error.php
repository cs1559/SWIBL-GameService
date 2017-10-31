<?php
namespace cjs\lib;

class Error {
    
    var $userMessage = null;
    var $internalMessage = null;
    var $code = null;
    var $reference = null;
    var $method = null;
    
    /**
     * @return the $method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param field_type $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return the $userMessage
     */
    public function getUserMessage()
    {
        return $this->userMessage;
    }

    /**
     * @return the $internalMessage
     */
    public function getInternalMessage()
    {
        return $this->internalMessage;
    }

    /**
     * @return the $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return the $reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param field_type $userMessage
     */
    public function setUserMessage($userMessage)
    {
        $this->userMessage = $userMessage;
    }

    /**
     * @param field_type $internalMessage
     */
    public function setInternalMessage($internalMessage)
    {
        $this->internalMessage = $internalMessage;
    }

    /**
     * @param field_type $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param field_type $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    
}