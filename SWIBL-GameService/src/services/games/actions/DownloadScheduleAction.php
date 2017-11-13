<?php 
namespace swibl\services\games\actions;

use Slim\Container;
use Exception;
use swibl\core\Error;
use swibl\core\exception\RecordNotFoundException;
use swibl\services\games\GameHelper;
use swibl\services\games\GameService;
use swibl\services\games\GameServiceResponse;
use swibl\services\games\GamesDAO;


/**
 * This class creates a downloable schedule.
 * @author Admin
 *
 */
class DownloadScheduleAction
{
   protected $container;
   
   public function __construct(Container $container) {
       $this->container = $container;
   }
   
   public function __invoke($request,  $response, $args) {
  
       $service = GameService::getInstance();
       $body = $request->getBody();
       $content = $body->getContents();
       
       $logger = $service->getLogger();
       $logger->info("POST /schedule " . $request->getUri() );
       
       $teamid = $request->getAttribute("teamid");
       $season = $request->getAttribute("seasonid");
             
       $dao = GamesDAO::getInstance($service->getDatabase());
       try {
           $results = $dao->getGameSchedule($teamid, $season);
           $games = GameHelper::bindArray($results);
           
           if ($games[0]->getHomeTeam() == $teamid) {
               $teamname = $games[0]->getHometeam();
           } else {
               $teamname = $games[0]->getAwayteam();
           }
           
           $response->write($teamname . "\r\n\r\n");
           
           // Header = game#, game date, game_time, hometeam
           $headerRow = "Game No, Date, Time, Home Team, Home Score, Away Team, Away Score, Location, Status";
           $response->write($headerRow . "\r\n");
           
           // Build formatted rows.
           foreach ($games as $game) {
               $tmp = array(
                   $game->getId(),
                   $game->getGameDate(),
                   $game->getGameTime(),
                   $game->getHometeam(),
                   $game->getHometeamScore(),
                   $game->getAwayteam(),
                   $game->getAwayteamScore(),
                   str_replace(","," ",$game->getLocation()),
                   $game->getGameStatus()
               );
               $gamecsv = implode(",", $tmp);
               $response->write($gamecsv . "\r\n");
           }
           return $response->withHeader('Content-Type','text/csv')->withHeader('Content-Disposition', 'attachment; filename=schedule.csv');
       }
       catch (RecordNotFoundException $e) {
           $logger->info("TEAM SCHEDULE NOT FOUND - " . $request->getUri());
           $svcresponse = new GameServiceResponse(400, $e->getMessage());
           $response->write(json_encode($svcresponse));
           return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
       }
       catch (Exception $e) {
           $error = new Error();
           $error->setSourcefile("file: " . $e->getFile() . " Line#: " . $e->getLine());
           $error->setMethod("GET /{id}");
           $error->setInternalMessage($e->getMessage());
           $svcresponse = new GameServiceResponse(400, $e->getMessage());
           $svcresponse->addError($error);
           $response->write(json_encode($svcresponse));
           return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
       }
       
       return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
       
  
   }
}
?>