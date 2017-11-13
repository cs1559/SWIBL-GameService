<?php 
namespace swibl\services\games;


/**
 * This object is used to build a GAME object.
 */
use Exception;
use swibl\core\ObjectBuilder;

class GameBuilder extends ObjectBuilder {
   
    /**
     * The fieldMap defines the table column name and the objects SETTER method
     * @var array
     */
    var $fieldMap = array(
        "id" => "setId",
        "division_id" => "setDivisionId",
        "season" => "setSeason",
        "game_date" => "setGameDate",
        "hometeam_id" => "setHometeamId",
        "awayteam_id" => "setAwayteamId",
        "hometeam_score" => "setHometeamScore",
        "awayteam_score" => "setAwayteamScore",
        "gametime" => "setGameTime",
        "game_time" => "setGameTime",    // need to change the object variable
        "hometeam_name" => "setHometeam",
        "awayteam_name" => "setAwayteam",
        "hometeam" => "setHometeam",  // need to change the object variable
        "awayteam" => "setAwayteam",  // need to change the object variable
        "hometeam_in_league"  => "setHomeLeagueFlag",
        "hometeaminleague" => "setHomeLeagueFlag",  // need to change the object variable
        "awayteam_in_league" => "setAwayLeagueFlag",
        "awayteaminleague" => "setAwayLeagueFlag",  // need to change the object variable
        "conference_game" => "setConferenceGame",
        "gamestatus" => "setGameStatus",  
        "status" => "setGameStatus",  // need to change the object variable
        "location" => "setLocation",
        "forfeit" => "setForfeit",
        "enteredby" => "setEnteredBy",
        "updatedby" => "setUpdatedBy",
        "highlights" => "setHighlights"
    );
    
    
    /**
     * This function will map an array and return a Game object.
     * {@inheritDoc}
     * @see \cjs\lib\AbstractMapper::map()
     * @return \swibl\Game;
     */
    public function build($result) {
        
        $game = new Game();
        
        try {
            $this->map($result, $this->fieldMap,$game);
        } catch (Exception $e) {
            throw $e;
        }
        
        return $game;
        
    }

}

?>