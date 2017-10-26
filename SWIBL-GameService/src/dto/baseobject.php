<?php 
namespace TeamMS;

class BaseObject implements \JsonSerializable {
    public function jsonSerialize()
    {
        $class_vars = get_class_vars(get_class($this));
        $jsonArray = array();
        foreach ($class_vars as $name => $value) {
            $jsonArray[$name] = $this->$name;
        }
        return $jsonArray;
     }
}