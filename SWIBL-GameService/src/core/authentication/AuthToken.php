<?php
namespace swibl\core\authentication;

class AuthToken {
    
    var $clientId = null;
    var $apiname = null;
    var $consumerkey = null;
    var $consumersecret = null;
    var $delete = false;
    var $get = true;
    var $put = false;
    var $post = false;
    /**
     * @return the $clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return the $apiname
     */
    public function getApiname()
    {
        return $this->apiname;
    }

    /**
     * @return the $consumerkey
     */
    public function getConsumerkey()
    {
        return $this->consumerkey;
    }

    /**
     * @return the $consumersecret
     */
    public function getConsumersecret()
    {
        return $this->consumersecret;
    }

    /**
     * @param field_type $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param field_type $apiname
     */
    public function setApiname($apiname)
    {
        $this->apiname = $apiname;
    }

    /**
     * @param field_type $consumerkey
     */
    public function setConsumerkey($consumerkey)
    {
        $this->consumerkey = $consumerkey;
    }

    /**
     * @param field_type $consumersecret
     */
    public function setConsumersecret($consumersecret)
    {
        $this->consumersecret = $consumersecret;
    }

    /**
     * @return the $delete
     */
    public function canDelete()
    {
        return $this->delete;
    }

    /**
     * @return the $get
     */
    public function canGet()
    {
        return $this->get;
    }

    /**
     * @return the $put
     */
    public function canPut()
    {
        return $this->put;
    }

    /**
     * @return the $post
     */
    public function canPost()
    {
        return $this->post;
    }

    /**
     * @param boolean $delete
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;
    }

    /**
     * @param boolean $get
     */
    public function setGet($get)
    {
        $this->get = $get;
    }

    /**
     * @param boolean $put
     */
    public function setPut($put)
    {
        $this->put = $put;
    }

    /**
     * @param boolean $post
     */
    public function setPost($post)
    {
        $this->post = $post;
    }

    
}