<?php
namespace swibl\services\games;

use swibl\services\games\GameService;
use swibl\core\RequestAuthorizer;
use swibl\core\authentication\AuthDAO;

class GameRequestAuthorizer extends RequestAuthorizer {
 
    function __construct() {
        self::setService(GameService::getInstance());
    }
 
    
}