<?php
namespace swibl\core;

class BaseObject {
    
    const VALID = 1;
    const INVALID = 0;
    
    var $objectstate = null;
    var $properties = null;
    
    function __construct() {
        $this->properties = array();
    }
    
    
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
    
    /**
     * This function will format all of the name/value properties so that they can be persisted
     * within a TEXT column within the database.
     *
     * @return varchar
     */
    function getFormattedProperties() {
        $props = '';
        foreach ($this->properties as $key => $val) {
            //$props .= $pro->getName() . "=" . $pro->getValue . "\n";
            $newval = str_ireplace("=","&#61;",$val);    // Clean the value to replace any EQUAL signs with the HTML code
            $props .= $key . "=" . $val . "\n";
        }
        return $props;
    }
    
    
}