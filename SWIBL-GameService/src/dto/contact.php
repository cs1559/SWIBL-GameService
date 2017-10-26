<?php
namespace TeamMS;

class Contact implements \JsonSerializable {
	
    private $id = null;
    private $teamid = null;
    private $name = null;
    private $email = null;
    private $phone = null;
    private $cellphone = null;
    private $role = null;
    private $userid = null;
    private $primary = null;
	
	function getId() {
		return $this->id;
	}
	function setId($inParm) {
		$this->id = $inParm;
	}
	function getTeamId() {
	    return $this->teamid;
	}
	function setTeamId($inParm) {
	    $this->teamid = $inParm;
	}

	function getName() {
		return $this->name;
	}
	function setName($inParm) {
		$this->name = $inParm;
	}	

	function getEmail() {
		return $this->email;
	}
	function setEmail($email) {
		$this->email = $email;
	}
	
	function getPhone() {
		return $this->phone;
	}
	function setPhone($phone) {
		$this->phone = $phone;
	}
	function getCellPhone() {
		return $this->cellphone;
	}
	function setCellPhone($phone) {
		$this->cellphone = $phone;
	}	
	function getRole() {
		return $this->role;
	}
	function setRole($role) {
		$this->role = $role;
	}
	
	function getUserid() {
		return $this->userid;	
	}
	function setUserid($uid) {
		$this->userid = $uid;
	}
	function setPrimaryContact($flag) {
	    $this->primary = $flag;
	}
	function isPrimaryContact() {
	    return $this->primary;
	}
    public function jsonSerialize()
    {
//         $class_vars = get_class_vars(get_class($this));
//         $jsonArray = array();
//         foreach ($class_vars as $name => $value) {
//             $jsonArray[$name] = $this->$name;
//         }
//         return $jsonArray;
       
         return [
             'id' => $this->getId(),
             'teamid' => $this->getTeamId(),
             'name' => $this->getName(),
             'email' => $this->getEmail(),
             'phone' => $this->getPhone(),
             'cellphone' => $this->getCellPhone(),
             'role' => $this->getRole(),
             'userid' => $this->getUserid(),
             'primarycontact' => $this->isPrimaryContact()
         ];

    }
}
?>