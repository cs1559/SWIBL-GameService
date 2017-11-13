<?php
namespace swibl\core;

abstract class ServiceRequest implements \JsonSerializable {
    
    protected $clientId = null;
    protected $token = null;
    protected $data = null;

    /**
     * @return the $clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return the $data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param field_type $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param field_type $data
     */
    abstract function setData(BaseObject $data);
    
    
    public function jsonSerialize() {
        return [
            'clientid' => $this->code,
            'token' => $this->token,
            'data' => $this->data
        ];
    }
    
}