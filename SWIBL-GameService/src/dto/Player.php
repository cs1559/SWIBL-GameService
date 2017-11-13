<?php
namespace TeamMS;

class Player {
	
	var $id = null;
	var $firstname = null;
	var $lastname = null;
	var $number = null;
	private  $dob = null;
	private $city = null;
	private $state = null;
	var $sub = 0;
	var $email = null;
	
	
	function getId() {
		return $this->id;
	}
	function setId($inParm) {
		$this->id = $inParm;
	}

	function getFirstName() {
		return $this->firstname;
	}
	function setFirstName($inParm) {
		$this->firstname = $inParm;
	}	
	function getLastName() {
		return $this->lastname;
	}
	function setLastName($inParm) {
		$this->lastname = $inParm;
	}	
	
	function getNumber() {
		return $this->number;
	}
	function setNumber($number) {
		$this->number = $number;
	}
	
	function getDateOfBirth() {
		return $this->dob;
	}
	function setDateOfBirth($dob) {
		$this->dob = $dob;
	}
	function getCity() {
		return $this->city;
	}
	function setCity($ht) {
		$this->city = $ht;
	}
	function getState() {
		return $this->state;
	}
	function setState($st) {
		$this->state = $st;
	}
	function setEmail($email) {
	    $this->email = $email;
	}
	function getEmail() {
	    return $this->email;
	}
	function setSubstitude($sub) {
	    $this->sub = $sub;
	}
	function isSubstitute() {
	    return $this->sub;
	}
 }
?>