<?php
namespace cjs\lib\exception;

class RequiredParameterMissingException extends \Exception {
    
    function __construct() {
        parent::__construct("Required Parameter missing in request", "500");
    }
}