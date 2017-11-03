<?php 
namespace swibl;

/**
 * This object is used to build a GAME object.
 */
use Exception;

class GameBuilder extends \cjs\lib\ObjectBuilder {
   
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