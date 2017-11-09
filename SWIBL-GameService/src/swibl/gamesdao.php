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
     * This function will INSERT a game object into the games table.
     */
    function insert(Game $obj) {
        $service = GameService::getInstance();
        $logger = $service->getLogger();
        
        // Throw an exception if the game object ID has a value other than 0 (zero)
        if ($obj->getId()) {
            throw new \Exception("Insert not allowed.  ID already populated");
        }
        
        $logger->debug("Attempting to INSERT record " . $obj->getId());
        
        $db = $this->getDatabase();
        $newGameDate = DateUtil::dateConvertForInput($obj->getGameDate());
        $logger->debug("after date conversion " . $obj->getId());
        
        $query = 'INSERT INTO joom_jleague_scores (id, division_id, season, game_date, hometeam_id, awayteam_id, '
            . 'hometeam_score,awayteam_score,forfeit,conference_game,hometeam_name,awayteam_name,hometeam_in_league,awayteam_in_league,'
            . 'properties,location,highlights,gametime,gamestatus, shortgame, enteredby, updatedby, dateupdated)'
            . ' VALUES (0,'
            . '"' . $obj->getDivisionId(). '",'
            . '"' . $obj->getSeason() . '",'
            . ' date("' . $newGameDate. '"), '
            . '"' . $obj->getHometeamId() . '",'
            . '"' . $obj->getAwayteamId() . '",'
            . '"' . $obj->getHometeamScore() . '",'
            . '"' . $obj->getAwayteamScore() . '",'
            . '"' . $obj->getForfeit() . '",'
            . '"' . $obj->getConferenceGame() . '",'
            . '"' . $obj->getHometeam() . '",'
            . '"' . $obj->getAwayteam() . '",'
            . '"' . $obj->getHomeLeagueFlag() . '",'
            . '"' . $obj->getAwayLeagueFlag() . '",'
                . '"",'   // ' . $obj->getFormattedProperties() . '
            . '"' . $obj->getLocation() . '",'
            . '"' . $obj->getHighlights() . '",'
            . '"' . $obj->getGameTime() . '",'
            . '"' . $obj->getGameStatus() . '",'
            . '"' . $obj->getShortgame() . '",'
            . '"' . $obj->getUpdatedBy() . '",'         // Entered by
            . '"' . $obj->getUpdatedBy() . '",'         // Updated by
            . 'NOW()'
            .  ')';
                                                                                                            
      
            $logger->debug($query);
            
            
            if (!$db->query($query)) {
                $logger->error($db->getErrorMsg());
                throw new Exception($db->getErrorMsg());
            } else {
                $logger->info("Record ID " . $db->insertId() . " has been INSERTED");
                return $db->insertId();
            }
            
 
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
     * This function will return an individual game.
     *
     * @param unknown $id
     * @throws Exception
     * @return array 
     */
    function delete($id) {
        
        $service = GameService::getInstance();
        $logger = $service->getLogger();
        
        $logger->debug("Attempting to DELETE record " . $id);
        
        $db = $this->getDatabase();
        $db->setQuery("delete from joom_jleague_scores where id = " . $id);
        try {
            $result = $db->query();
            $logger->info("Total records deleted is " . $db->getAffectedRows());
            if ($db->getAffectedRows() == 0) {
                throw new Exception("NO RECORDS DELETED");
            }
        } catch (\Exception $e) {
            $logger->error($db->getErrorMsg());
            throw $e;
        }
        return true;
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
     *  This function will update a game record.
     */
    function update(Game $obj) {
        $service = GameService::getInstance();
        $logger = $service->getLogger();
        $logger->debug("Attempting to update record " . $obj->getId());
        
        $db = $this->getDatabase();
        $newGameDate = DateUtil::dateConvertForInput($obj->getGameDate());
        $logger->debug("after date conversion " . $obj->getId());
        
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
          
            $logger->debug($query);

            
            if (!$db->query($query)) {
                $logger->error($db->getErrorMsg());
                throw new Exception($db->getErrorMsg());
            } else {
                $logger->info("Record ID " . $obj->getId() . " has been updated");
                return true;
            }	                                                                                              
    }
    
}