<?php
namespace swibl\services\games;

use Psr\Http\Message\ServerRequestInterface;
use swibl\core\RequestAuthorizer;

class GameRequestAuthorizer extends RequestAuthorizer {
 
    function __construct() {
        self::setService(GameService::getInstance());
    }
 
    function checkServiceAuthorizations(ServerRequestInterface $request) {
        return true;
    }
}