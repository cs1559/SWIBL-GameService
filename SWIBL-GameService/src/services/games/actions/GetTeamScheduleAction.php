<?php 
namespace swibl\services\games\actions;


use Slim\Container;
use Exception;
use swibl\core\Error;
use swibl\core\exception\RecordNotFoundException;
use swibl\services\games\GameBuilder;
use swibl\services\games\GameHelper;
use swibl\services\games\GameService;
use swibl\services\games\GameServiceResponse;
use swibl\services\games\GamesDAO;

class GetTeamScheduleAction
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
       
       $uri = $request->getUri();
       
       $params = $request->getQueryParams();
       
//        if (isset($params["season"])){
//            $season = $params["season"];
//        } else {
//            $svcresponse = GameServiceResponse::getInstance(400, "Season ID is missing from the request - " . "GET /schedule/{teamid}");
//            $response->write(json_encode($svcresponse));
//            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
//        }
       
       $teamid = $request->getAttribute("teamid");
       $season = $request->getAttribute("seasonid");
       
       $dao = GamesDAO::getInstance($service->getDatabase());
       try {
           $results = $dao->getGameSchedule($teamid, $season);
           
           $games = GameHelper::bindArray($results);
                     
           $svcresponse = GameServiceResponse::getInstance(200, "Schedule Retrieved [" . sizeof($games) . "]");
           $svcresponse->setData($games);
           $response->withHeader('Content-Type', 'application/json');
           $response->write(json_encode($svcresponse));
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