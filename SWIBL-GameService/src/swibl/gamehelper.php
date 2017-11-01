<?php
namespace swibl;

require_once ("game.php");

/**
 * 
 * @author Admin
 *
 */
class GameHelper {
    
    /**
     * This method will map/bind an individual item returned by the REST API to the Team object.
     * 
     * @param unknown $result
     * @return \TeamMS\Team
     */
    public static function bind($result) {
 
        $fieldMap = array(
            "id" => "setId",
            "division_id" => "setDivisionId",
            "season" => "setSeason",
            "game_date" => "setGameDate",
            "hometeam_id" => "setHometeamId",
            "awayteam_id" => "setAwayteamId",
            "hometeam_score" => "setHometeamScore",
            "awayteam_score" => "setAwayteamScore",
            "gametime" => "setGameTime",
            "hometeam_name" => "setHometeam",
            "awayteam_name" => "setAwayteam",
            "hometeam_in_league"  => "setHomeLeagueFlag",
            "awayteam_in_league" => "setAwayLeagueFlag",
            "conference_game" => "setConferenceGame",
            "gamestatus" => "setGameStatus",
            "location" => "setLocation",
            "forfeit" => "setForfeit",
            "enteredby" => "setEnteredBy",
            "updatedby" => "setUpdatedBy",
            "highlights" => "setHighlights"
        );
        
        // Convert result object to an array
        $objVars = get_object_vars($result);
        
        $game = new Game();
        foreach ($fieldMap as $field => $method) {
            if (isset($objVars[$field]))
                $game->$method($objVars[$field]);         
        }
        $game->setObjectState(true);
        
        return $game;   
    }
    
    
    /**
     * This method will map/bind an individual item returned by the REST API to the Team object.
     *
     * @param unknown $result
     * @return \TeamMS\Team
     */
    public static function bindJSON($result) {
//         $team = new \TeamMS\Team();
//         $team->setId($result->id);
//         $team->setName($result->name);
//         $team->setWebsite($result->website_url);
//         $team->setCity($result->city);
//         $team->setState($result->state);
//         $team->setLogo($result->logo);
//         $team->setCoachEmail($result->coachemail);
//         $team->setCoachName($result->coachname);
//         $team->setCoachPhone($result->coachphone);
//         $team->setOwnerId($result->ownerid);
//         $team->setHits($result->hits);
//         $team->setLastUpdated($result->lastupdated);
//         $team->setLastUpdatedBy($result->lastupdatedby);
     
        return $team;
    }
    
    
    /**
     * This method will take an array of JSON objects returned from a query and binds each JSON record to a Team object.  The method
     * will return an array of Team objects.
     * 
     * @param array $inArray
     * @return array[]
     */
    public static function bindArray($inArray) {
        if (!is_array($inArray)) {
            throw new \Exception("Input value is not an array");
        }
        $returnArray = array();
        
        foreach ($inArray as $item) {
            if (is_object($item)) {
//                 $team = TeamHelper::bindJSON($item);
            } else {
//                 $team = TeamHelper::bind($item);
            }
            $returnArray[] = $team;
        }
        return $returnArray;
    }


}