<?php
namespace swibl;

use cjs\lib\Database;
use cjs\lib\DateUtil;
use Exception;

// use cjs\lib\Factory;

class GamesDAO {
    
    private $database = null;

    /**
     * Private constructor to ensure that the object cannot be instantiated by a client.
     */
    private function __construct() {
    }
    
    static function getInstance(Database $db) {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new GamesDAO();
        }
        $instance->setDatabase($db);
        return $instance;
    }
    
    function getDatabase() {
        return $this->database;
    }
    function setDatabase($db) {
        $this->database = $db;
    }
    
    /**
     * This function will return an individual game.
     * 
     * @param unknown $id 
     * @throws Exception
     * @return array
     */
    function getGame($id) {
        
        $db = $this->getDatabase();
        $db->setQuery("select * from joom_jleague_scores where id = " . $id);
        try {
            $result = $db->loadObject(); 
         } catch (\Exception $e) { 
            throw $e;
        }
        return $result;
    }
    
    /**
     * This function will return the game schedule for a team / season.
     * @param unknown $teamid
     * @param unknown $season
     * @throws Exception
     * @return array
     */
    function getGameSchedule($teamid, $season) {
        
        $db = $this->getDatabase();
        $db->setQuery("select * from joom_jleague_scores where season = " . $season . " and (awayteam_id = " . $teamid . " or hometeam_id = " . $teamid . ")");
        try {
            $games = $db->loadObjectList();
        } catch (\Exception $e) {
            throw $e;
        }
        return $games;
    }

    /**
     * 
     */
    function update(Game $obj) {
        $service = GameService::getInstance();
        $logger = $service->getLogger();
        $logEnabled = $service->isLogEnabled();
        if ($logEnabled) {
            $logger->info("Attempting to update record " . $obj->getId());
        }
        
        $db = $this->getDatabase();
        $newGameDate = DateUtil::dateConvertForInput($obj->getGameDate());
        if ($logEnabled) {
            $logger->info("after date conversion " . $obj->getId());
        }
        $query = 'update joom_jleague_scores set '
            . ' division_id = "' . $obj->getDivisionId(). '", '
            . ' season = "' . $obj->getSeason(). '", '
            . ' game_date = date("' . $newGameDate. '"), '
            . ' hometeam_id = "' . $obj->getHometeamId(). '", '
            . ' awayteam_id = "' . $obj->getAwayteamId(). '", '
            . ' hometeam_score = "' . $obj->getHometeamScore(). '", '
            . ' awayteam_score = "' . $obj->getAwayteamScore(). '", '
            . ' forfeit = "' . $obj->getForfeit(). '", '
            . ' conference_game = "' . $obj->getConferenceGame(). '", '
            . ' hometeam_name = "' . $obj->getHometeam(). '", '
            . ' awayteam_name = "' . $obj->getAwayteam(). '", '
            . ' hometeam_in_league = "' . $obj->getHomeLeagueFlag(). '", '
            . ' awayteam_in_league = "' . $obj->getAwayLeagueFlag(). '", '
//             . ' properties = "' . $obj->getFormattedProperties(). '", '
            . ' location = "' . $obj->getLocation(). '", '
            . ' highlights = "' . $obj->getHighlights(). '", '
            . ' gametime = "' . $obj->getGameTime(). '", '
            . ' gamestatus = "' . $obj->getGameStatus(). '", '
            . ' shortgame = "' . $obj->getShortgame(). '", '
            . ' updatedby = "' . $obj->getUpdatedBy() . '", '
            . ' dateupdated = NOW() '
            . ' where id = ' . $obj->getId();
          
            $logger->info("After setting query");
            $logger->info($query);

            
            if (!$db->query($query)) {
                if ($logEnabled) {
                    $logger->error($db->getErrorMsg());
                }
                throw new Exception($db->getErrorMsg());
            } else {
                if ($logEnabled) {
                    $logger->info("Record ID " . $obj->getId() . " has been updated");
                }
                return true;
            }	                                                                                              
    }
    
}