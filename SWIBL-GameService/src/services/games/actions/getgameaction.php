<?php 
namespace swibl\services\games\actions;

use Slim\Container;
use Exception;
use swibl\core\Error;
use swibl\core\exception\RecordNotFoundException;
use swibl\services\games\GameBuilder;
use swibl\services\games\GameService;
use swibl\services\games\GameServiceResponse;
use swibl\services\games\GamesDAO;

class GetGameAction
{
   protected $container;
   
   public function __construct(Container $container) {
       $this->container = $container;
   }
   
   public function __invoke($request, $response, $args) {
   
        $service = GameService::getInstance();
        $logger = $service->getLogger();
        $logger->info("GET /" . $request->getAttribute('id') );
        $dao = GamesDAO::getInstance($service->getDatabase());
       
        try {
            $result = $dao->getGame($request->getAttribute('id'));
            $logger->debug("Building Game " . $request->getAttribute('id') . " Object");
            $builder = new GameBuilder();
            $game = $builder->build($result);
            $logger->debug("Game object " . $request->getAttribute('id') . " built");
            
            $svcresponse = GameServiceResponse::getInstance(200,"Record retrieved");
            $svcresponse->setData($game);
            $response->write(json_encode($svcresponse));
        }
        catch (RecordNotFoundException $e) {
            $svcresponse = GameServiceResponse::getInstance(400, $e->getMessage());
            $response->write(json_encode($svcresponse));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        catch (Exception $e) {
            $error = new Error();
            $error->setSourcefile("file: " . $e->getFile() . " Line#: " . $e->getLine());
            $error->setMethod("GET /{id}");
            $error->setInternalMessage($e->getMessage());
            $svcresponse = GameServiceResponse::getInstance(400, $e->getMessage());
            $svcresponse->addError($error);
            $response->write(json_encode($svcresponse));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
   }
}
?>