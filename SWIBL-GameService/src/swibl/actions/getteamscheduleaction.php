<?php 
namespace swibl\actions;

use Slim\Container;
use Exception;
use swibl\GameBuilder;
use swibl\GameService;
use swibl\GameServiceResponse;

class GetTeamScheduleAction
{
   protected $container;
   
   public function __construct(Container $container) {
       $this->container = $container;
   }
   
   public function __invoke($request, $response, $args) {
  
       
       $uri = $request->getUri();
       
       $params = $request->getQueryParams();
       
       if (isset($params["season"])){
           $season = $params["season"];
       } else {
           $svcresponse = GameServiceResponse::getInstance(400, "Season ID is missing from the request - " . "GET /schedule/{teamid}");
           $response->write(json_encode($svcresponse));
           return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
       }
       
       $teamid = $request->getAttribute("teamid");
       $dao = new \swibl\GamesDAO();
       try {
           $results = $dao->getGameSchedule($teamid, $season);
           $games = \swibl\GameHelper::bindArray($results);
           $svcresponse = GameServiceResponse::getInstance(200, "Schedule Retrieved");
           $svcresponse->setData($games);
           //             $svcresponse->setCode(200);
           //             $svcresponse->setData($games);
           $response->withHeader('Content-Type', 'application/json');
           $response->write(json_encode($svcresponse));
       }
       catch (\cjs\lib\exception\RecordNotFoundException $e) {
           $svcresponse = new GameServiceResponse();
           $svcresponse->setCode(400);
           $svcresponse->setMessage($e->getMessage());
           $response->write(json_encode($svcresponse));
           return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
       }
       catch (Exception $e) {
           $error = new \cjs\lib\Error();
           $error->setSourcefile("file: " . $e->getFile() . " Line#: " . $e->getLine());
           $error->setMethod("GET /{id}");
           $error->setInternalMessage($e->getMessage());
           $svcresponse = new GameServiceResponse();
           $svcresponse->setCode(400);
           $svcresponse->setMessage($e->getMessage());
           $svcresponse->addError($error);
           $response->write(json_encode($svcresponse));
           return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
       }
       
       return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
       
  
   }
}
?>