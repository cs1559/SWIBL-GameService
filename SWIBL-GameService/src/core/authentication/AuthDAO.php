<?php
namespace swibl\core\authentication;

use Exception;
use swibl\core\Database;

class AuthDAO {
    
    private $database = null;

    /**
     * Private constructor to ensure that the object cannot be instantiated by a client.
     */
    private function __construct() {
    }
    
    static function getInstance(Database $db) {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new AuthDAO();
        }
        $instance->setDatabase($db);
        return $instance;
    }
    
    function getDatabase() {
        return $this->database;
    }
    function setDatabase($db) {
        $this->database = $db;
    }
    
    /**
     * This function will return an individual game.
     * 
     * @param unknown $id 
     * @throws Exception
     * @return AuthToken;
     */
    function getAuthToken($clientid) {
        
        $db = $this->getDatabase();
        $db->setQuery("select * from client_authorization where clientid = '" . $clientid . "'");
        try {
            $result = $db->loadObject(); 
            $token = new AuthToken();
            $token->setClientId($result->clientid);
            $token->setConsumersecret($result->consumer_secret);
            $token->setConsumerkey($result->consumer_key);
            $token->setDelete($result->allow_delete);
            $token->setPost($result->allow_post);
            $token->setPut($result->allow_put);
            $token->setGet($result->allow_get);
            return $token;
         } catch (\Exception $e) { 
            throw $e;
        }
        return $result;
    }
    
}