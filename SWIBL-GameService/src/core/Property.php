<?php
namespace swibl\core;

class Property {
    
    private $name = null;
    private $value = null;
    
    
    /**
     * Constructor initializing the name and value of the property
     *
     * @param string $inName
     * @param object $inValue
     */
    function __construct($inName, $inValue) {
        $this->name = $inName;
        $this->value = $inValue;
    }
    
    /**
     * Returns the property name
     *
     * @return string
     */
    function getName() {
        return $this->name;
    }
    
    /**
     * Returns the value of the property
     *
     * @return object
     */
    function getValue() {
        return $this->value;
    }
    
    function __toString() {
        return "PROPERTY:  name= " . self::getName() . " value = " . self::getValue();
    }
    
}
?>
