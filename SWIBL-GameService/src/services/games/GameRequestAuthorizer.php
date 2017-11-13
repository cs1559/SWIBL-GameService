<?php
namespace swibl\services\games;

use Psr\Http\Message\ServerRequestInterface;
use swibl\services\games\GameService;
use swibl\core\RequestAuthorizer;
use swibl\core\authentication\AuthDAO;

class GameRequestAuthorizer extends RequestAuthorizer {
 
    function __construct() {
        self::setService(GameService::getInstance());
    }
 
    function checkServiceAuthorizations(ServerRequestInterface $request) {
        return true;
    }
}