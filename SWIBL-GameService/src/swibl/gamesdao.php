<?php
namespace swibl;

class GamesDAO {
    
    /**
     * This function will return an individual game.
     * 
     * @param unknown $id 
     * @throws Exception
     * @return array
     */
    function getGame($id) {
        
        $db = &\cjs\lib\Factory::getDatabase();
        $db->setQuery("select * from joom_jleague_scores where id = " . $id);
        try {
            $game = $db->loadObject(); 
        } catch (\Exception $e) {
            throw $e;
        }
        return $game;
    }
    
    /**
     * This function will return the game schedule for a team / season.
     * @param unknown $teamid
     * @param unknown $season
     * @throws Exception
     * @return array
     */
    function getGameSchedule($teamid, $season) {
        
        $db = \cjs\lib\Factory::getDatabase();
        $db->setQuery("select * from joom_jleague_scores where season = " . $season . " and (awayteam_id = " . $teamid . " or hometeam_id = " . $teamid . ")");
        try {
        $games = $db->loadObjectList();
        } catch (\Exception $e) {
            throw $e;
        }
        return $games;
    }

}