<?php
namespace TeamMS;

class Team implements \JsonSerializable {
	
	private $id = null;
	private $name = null;
	private $website_url=null;
	private $city = null;
	private $state = null;
	private $logo = null;
	private $coachname = null;
	private $coachemail = null;
	private $coachphone = null;
	private $ownerid = null;
	private $hits = 0;
	private $lastseason = null;
	private $shortname = null;
	private $lastupdated = null;
	private $lastupdatedby=null;
	
	function getId() {
		return $this->id;
	}
	function setId($inParm) {
		$this->id = $inParm;
	}

	function getName() {
		return $this->name;
	}
	function setName($inParm) {
		$this->name = $inParm;
	}	
		
	function getWebsite() {
		return $this->website_url;
	}
	
	function setWebsite($inParm) {
		$this->website_url = $inParm;
	}	
	
	function getContacts() {
		return $this->contacts;
	}
	
// 	function addContact(JLContact $contact) {
// 		$this->contacts[] = $contact;
// 	}
	
	function getCity() {
		return $this->city;
	}
	function setCity($city) {
		$this->city = $city;
	}
	function getState() {
		return $this->state;
	}
	function setState($state) {
		$this->state = $state;
	}
	function getLogo() {
		if (strlen($this->logo) > 0) {
			return $this->logo;
		} else
			return "default-logo.jpg";
	}
	function setLogo($fn) {
		$this->logo = $fn;
	}
	function setDivision($div) {
		$this->division = $div;
	}
	function getDivision() {
		return $this->division;
	}
	function setSeason($season) {
		$this->season = $season;
	}
	function getSeason() {
		return $this->season;
	}
	function getCustomFields() {
		return $this->fields;
	}
	function setCustomFields(array $fields=null) {
		$this->fields = $fields;
	}
	function getFieldName($key) {
		if (isset($this->fields[$key])) {
			$fld = $this->fields[$key];
			if (is_object($fld)) {
				return $fld->getName();
			}
			return null;
		}
		return null;
	}
	
	function getFieldValue($key) {
		if (isset($this->fields[$key])) {
			$fld = $this->fields[$key];
			if (is_object($fld)) {
				return $fld->getValue();
			}
			return null;
		}
		return null;
	}
// 	function setField(fsField $fld) {
// 		$this->fields[$fld->getKeycode()] = $fld;
// 	}
	
	function setOwnerId($ownerid) {
		$this->ownerid = $ownerid;
	}
	function getOwnerId() {
		return $this->ownerid;
	}
	
	function setCommunityItem($item) {
		$this->communityitem = $item;
	}
	function getCommunityItem() {
		return $this->communityitem;
	}
	
	function setCoachName($name) {
		$this->coachname = $name;
	}
	function getCoachName() {
		return $this->coachname;
	}
	function setCoachEmail($email) {
		$this->coachemail = $email;
	}
	function getCoachEmail() {
		return $this->coachemail;
	}
	function setCoachPhone($phone) {
		$this->coachphone = $phone;
	}
	function getCoachPhone($phone) {
	    return $this->coachphone;
	}
// 	function getCoachPhone() {
// 		$svc = &JLSecurityService::getInstance();
// 		if ($svc->isUserAssociatedWithTeam()) {
// 			return $this->coachphone;
// 		} else {
// 			return "Unavailable";
// 		}
		
// 	}
	function getFieldDirections() {
		return $this->fielddirections;
	}
	function setFieldDirections($directions) {
		$this->fielddirections = $directions;
	}
	function getHomeField() {
		return $this->homefield;
	}
	function setHomeField($field) {
		$this->homefield = $field;
	}
	function getFieldAddress() {
		return $this->field_address;
	}
	function setFieldAddress($addr) {
		$this->field_address = $addr;
	}	
	function getFieldLatitude() {
		return $this->field_latitude;
	}
	function setFieldLatitude($lat) {
		$this->field_latitude = $lat;
	}
	function getFieldLongitude() {
		return $this->field_longitude;
	}
	function setFieldLongitude($lng) {
		$this->field_longitude = $lng;
	}
	function setHits($hits) {
		$this->hits = $hits;
	}
	function getHits() {
		return $this->hits;
	}
	function getLastSeason() {
		return $this->lastseason;
	}
	function setLastSeason($lastseason) {
		$this->lastseason = $lastseason;
	}
	function setAgeGroup($age) {
	    $this->agegroup = $age;
	}
	function getAgeGroup() {
// 		if ($this->division != null) {
// 			return $this->division->getAgeGroup();
// 		} else {
// 			return "N/A";
// 		}
        return $this->agegroup;
	}
	
	function getSlug() {
		return parent::getSlug($this->id, $this->name);
	}
	
	/**
	 * Set the short/abbreviated name 
	 *
	 * @param String $name
	 */
	function setShortName($name) {
		$this->shortname = $name;
	}
	/**
	 * Returns the short/abbreviate team name
	 *
	 * @return String
	 */
	function getShortName() {
		return $this->shortname;
	}
	
	function getLastUpdated() {
	    return $this->lastupdated;
	}
	function setLastUpdated($val) {
	    $this->lastupdated = $val;
	}
	function getLastUpdatedBy() {
	    return $this->lastupdatedby;
	}
	function setLastUpdatedBy($val) {
	    $this->lastupdatedby = $val;
	}
	
	public function jsonSerialize()
	{
  
	    return [
	        'id' => $this->getId(),
	        'name' => $this->getName(),
	        'coachname' => $this->getCoachName(),
	        'coachemail' => $this->getCoachEmail(),
	        'coachphone' => $this->get,
	        'city' => $this->getCity(),
	        'state' => $this->getState(),
	        'logo' => $this->getLogo(),
	        'website_url' => $this->getWebsite(),
	        'ownerid' => $this->getOwnerId(),
	        'hits' => $this->getHits(),
	        'lastupdated' => $this->getLastUpdated(),
	        'lastupdatedby' => $this->getLastUpdatedBy()
	     ];
    }

}