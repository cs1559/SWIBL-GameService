<?php
namespace swibl\core\exception;

class RecordNotFoundException extends \Exception {
    
    function __construct() {
        parent::__construct("Record Not Found", "500");
    }
}