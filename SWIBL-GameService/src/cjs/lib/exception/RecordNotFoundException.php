<?php
namespace cjs\lib\exception;

class RecordNotFoundException extends \Exception {
    
    function __construct() {
        parent::__construct("Record Not Found", "500");
    }
}