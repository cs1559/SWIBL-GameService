<?php
namespace cjs\lib;

class BaseObject {
    
    const VALID = 1;
    const INVALID = 0;
    
    var $state = null;
   
    public function getState() {
        return $this->state;
    }
    
}