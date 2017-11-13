<?php
namespace swibl\core\exception;

class RequiredParameterMissingException extends \Exception {
    
    function __construct() {
        parent::__construct("Required Parameter missing in request", "500");
    }
}