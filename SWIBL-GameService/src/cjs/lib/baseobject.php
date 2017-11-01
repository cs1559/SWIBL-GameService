<?php
namespace cjs\lib;

class BaseObject {
    
    const VALID = 1;
    const INVALID = 0;
    
    var $objectstate = null;
   
    public function getObjectState() {
        if (is_null($this->objectstate)) {
            return cjs\lib\BaseObject\VALID;
        } else {
            return $this->objectstate;
        }
    }
    public function setObjectState($value) {
        $this->objectstate = $value;
    }
    
}