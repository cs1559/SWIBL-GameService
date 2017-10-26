<?php
namespace TeamMS;

require_once ("player.php");

class Roster  { 
	  
    // Maximum number of players allowed on roster
    const MAXPLAYERS = 15;
    
    // Maximum number of PRIMARY players on roster
    const MAXPRIMARY = 12;
    
    // Maximum number of SUBSTITUTE players allowed
    const MAXSUBS = 3;
    
	var $teamid = null;
	var $season = null;
	var $players = null;
	var $valid = null;
	var $total_substitutes = 0;
	var $total_regulars = 0;
	
	function __construct() {
		$this->players = array();	
	}
	
	function getTeamId() {
		return $this->teamid;
	}
	function setTeamId($teamid) {
		$this->teamid = $teamid;
	}	

	function getSeason() {
		return $this->season;
	}
	function setSeason($season) {
		$this->season = $season;
	}
	
	function getPlayers() {
		return $this->players;
	}
	function addPlayer(\TeamMS\Player $player) {
		$this->players[] = $player;
		if ($player->isSubstitute()) {
		    $this->total_substitutes = $this->total_substitutes + 1;
		} else {
		    $this->total_regulars = $this->total_regulars + 1;
		}
		$this->checkCount();
	}
	
	function checkCount() {
	   $this->valid = false;
	   if (count($this->players) <= self::MAXPLAYERS) {
	       $this->valid = true;
	   }
	   if ($this->total_regulars > self::MAXPRIMARY) {
	       $this->valid = false;
	   }
	   if ($this->total_substitutes > self::MAXSUBS) {
	       $this->valid = false;
	   }
	}
	
	function getPlayerCount() {
		return count($this->players);
	}
	
	function hasPlayers() {
		return count($this->players);
	}
}
?>
