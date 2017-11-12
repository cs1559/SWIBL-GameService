<?php
namespace swibl\core;

class Config {
    
    var $properties = null;
    
    static function getInstance() {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new self();
        }
        return $instance;
    }
    
    
    function setProperty($inname, $invalue) {
        $this->addProperty($inname, $invalue);
    }
    function addProperty($inname, $invalue) {
        $prop = new Property($inname, ltrim($invalue));
        $this->setPropertyObject($prop);
    }
    private function setPropertyObject(Property $prop) {
        $this->properties[$prop->getName()] = $prop->getValue();
    }
    
    function setProperties($inParm) {
        $this->props = $inParm;
    }
    function getProperties() {
        return $this->props;
    }
    function getPropertyValue($key) {
        if ($this->properties == null)
            return null;
            if (isset($this->properties[$key])) {
                return $this->properties[$key];
            } else {
                return null;
            }
    }
    function getProperty($key) {
        return $this->getPropertyValue($key);
    }
}

?>