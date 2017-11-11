<?php 
namespace swibl\actions;

use Slim\Container;
use Exception;
use swibl\GameBuilder;
use swibl\GameService;
use swibl\GameServiceResponse;

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
        $dao = \swibl\GamesDAO::getInstance($service->getDatabase());
       
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
        catch (\cjs\lib\exception\RecordNotFoundException $e) {
            $svcresponse = GameServiceResponse::getInstance(400, $e->getMessage());
            $response->write(json_encode($svcresponse));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        catch (Exception $e) {
            $error = new \cjs\lib\Error();
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