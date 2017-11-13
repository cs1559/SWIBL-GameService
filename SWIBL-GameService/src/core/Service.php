<?php
namespace swibl\core;

abstract class Service {

	var $name = null;
	var $version = null;
	var $properties = array();

	function setName($name) {
		$this->appname = $name;
	}
	function getName() {
		return $this->appname;
	}
	
	function setVersion($ver) {
		$this->appversion = $ver;
	}
	function getVersion() {
		return $this->appversion;
	}
	
	function setProperty($key, $value) {
		$this->properties[$key] = $value;
	}
	function getProperty($key) {
		return $this->properties[$key];	
	}
	
	
	/*
	function addProperty($inname, $invalue) {
		$prop = new fsProperty($inname, ltrim($invalue));
		$this->setPropertyObject($prop);
	}
	private function setPropertyObject(fsProperty $prop) {
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
	*/

}

?>