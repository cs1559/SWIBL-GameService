<?php
namespace swibl;

/**
 * @version		$Id: game.class.php 450 2012-12-18 10:21:13Z cs1559 $
 * @package 	JLeague
 * @subpackage	Objects
 * @copyright 	(C) 2006-2012 Chris Strieter, Firestorm Technologies, LLC
 * @license		GNU/GPL, see LICENSE.php
 */

/**
 * JLGame represents a GAME event.  
 * 
 * GAME STATUS:
 * 
 *    C = Completed
 *    R = Rained Out
 *    X = Cancelled
 *      = Suspended
 *    S = Scheduled  
 *
 */

class Game extends \cjs\lib\BaseObject {
  var $id=null;
  var $division_id=null;
  var $season=null;
  var $game_date=null;
  var $game_time = null;
  var $hometeaminleague=null;
  //var $homeflag = null;
  var $awayteaminleague=null;
  //var $awayflag = null;  
  var $hometeam = null;
  var $hometeam_id=null;
  var $hometeam_score=null;
//  var $hometeam_points=null;
  var $awayteam = null;    
  var $awayteam_id=null;
  var $awayteam_score=null;    
//  var $awayteam_points=null;
  var $forfeit=null;
  var $conference_game=null;
  var $location=null;    
  var $status = null;
  var $highlights = null;
  var $properties = null;
  var $divisionobj = null;
  var $enteredby = null;
  var $shortgame = 0;
  var $_homelogo = null;
  var $_awaylogo = null;
  
	function setId($inParm) {
		$this->id = $inParm;
	}
	function getId() {
		return $this->id;
	}
	function setDivisionId($inParm) {
		$this->division_id = $inParm;
	}
	function getDivisionId() {
		return $this->division_id;
	}
	function setDivision($inobj) {
		$this->divisionobj = $inobj;
	}
	function getDivision() {
		return $this->divisionobj;
	}
	function setSeason($inParm) {
		$this->season = $inParm;
	}
	function getSeason() {
		return $this->season;
	}
	function setGameDate($inParm) {
		$this->game_date = $inParm;
	}
	function getGameDate() {
		return $this->game_date;
	}
	function setGameTime($inParm) {
		$this->game_time = $inParm;
	}
	function getGameTime() {
		return $this->game_time;
	}	
	function setHometeamId($inParm) {
		$this->hometeam_id = $inParm;
	}
	function getHometeamId() {
		if ($this->getHomeLeagueFlag() == "N") {
			return 0;
		} else {
			return $this->hometeam_id;
		}
	}
	function setHometeam($inParm) {
		$this->hometeam = $inParm;
	}
	function getHometeam() {
		return $this->hometeam;	
	}
	function setAwayteamId($inParm) {
		$this->awayteam_id = $inParm;
	}
	function getAwayteamId() {
	//	echo 'AWAYTEAM IN LEAGUE? ' . $this->getAwayteamInLeague() . ' -- getAwayteamId()<BR>';		
		if ($this->getAwayLeagueFlag() == "N") {
			return 0;
		}
		else {
			return $this->awayteam_id;
		}
	}
	function setAwayteam($inParm) {
		$this->awayteam = $inParm;
	}
	function getAwayteam() {
		return $this->awayteam;	
	}	
	function setHometeamScore($inParm) {
		$this->hometeam_score = $inParm;
	}
	function getHometeamScore() {
		return $this->hometeam_score;
	}
	function setAwayteamScore($inParm) {
		$this->awayteam_score = $inParm;
	}
	function getAwayteamScore() {
		return $this->awayteam_score;
	}
	
	/*
	function setHometeamPoints($inParm) {
		$this->hometeam_points = $inParm;
	}
	function getHometeamPoints() {
		return $this->hometeam_points;
	}
	function setAwayteamPoints($inParm) {
		$this->awayteam_points = $inParm;
	}
	function getAwayteamPoints() {
		return $this->awayteam_points;
	}
*/
	function isComplete() {
		if ($this->status == "C") {
			return true;
		} else {
			return false;
		}
	}
	
	function isLeagueGame() {
		if ($this->conference_game == "Y") {
			return true;
		} else {
			return false;
		}
	}
	function setConferenceGame($inParm) {
		$this->conference_game = $inParm;
	}
	function getConferenceGame() {
		//if ($this->getAwayLeagueFlag() == "N" || $this->getHomeLeagueFlag() == "N") { 
		//	return 'N';
		//}
		//else {
			return $this->conference_game;
		//}
	}
	function setForfeit($inParm) {
		$this->forfeit = $inParm;
	}
	function getForfeit() {
		if ($this->forfeit == null) {
			return 'N';
		}
		return $this->forfeit;
	}	
	
 	function setHomeLeagueFlag($inParm) {
 		$this->hometeaminleague = $inParm;
 	}
 	function getHomeLeagueFlag() {
 		return $this->hometeaminleague;
 	}
	function setAwayLeagueFlag($inParm) {
 		$this->awayteaminleague = $inParm;
 	}
 	function getAwayLeagueFlag() {
 		return $this->awayteaminleague;
 	}
 	function setLocation($inParm) {
 		$this->location = $inParm;
 	}
 	function getLocation() {
 		return $this->location;
 	}
 	function setGameStatus($inParm) {
 		$this->status = $inParm;
 	}
 	function getGameStatus() {
 		return $this->status;
 	}
 	function setHighlights($inParm) {
 		$this->highlights = $inParm;
 	}
 	function getHighlights() {
 		return $this->highlights;
 	}
	
 	function setEnteredBy($parm) {
 		$this->enteredby = $parm;
 	}
 	function getEnteredBy() {
 		return $this->enteredy;
 	}
 	function setShortgame($ind) {
 		$this->shortgame = $ind;
 	}
 	function getShortgame() {
 		return $this->shortgame;
 	}
 	function setHometeamLogo($logo) {
 		$this->_homelogo = $logo;
 	}
 	function getHometeamLogo() {
 		return $this->_homelogo;
 	}
 	function setAwayteamLogo($logo) {
 		$this->_awaylogo = $logo;
 	}
 	function getAwayteamLogo() {
 		return $this->_awaylogo;
 	}
 	
}
