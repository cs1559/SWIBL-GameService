<?php
namespace swibl\services\games\actions;


use Slim\Container;
use Exception;
use swibl\services\games\GameBuilder;
use swibl\services\games\GameService;
use swibl\services\games\GameServiceResponse;
use swibl\services\games\GamesDAO;

class PutGameAction
{
    protected $container;
    
    public function __construct(Container $container) {
        $this->container = $container;
    }
    
    public function __invoke($request, $response, $args) {
        
        $service = GameService::getInstance();
        
        $id = $request->getAttribute("id");
        $body = $request->getBody();
        $content = $body->getContents();
        
        $logger = $service->getLogger();
        $logger->info("PUT /" . $content );
        
        $dao = GamesDAO::getInstance($service->getDatabase());
        try {
            $builder = new GameBuilder();
            $logger->debug( $content);
            $game = $builder->build(json_decode($content));
            $dao->update($game);
            $svcresponse = new GameServiceResponse(200, "Record " . $game->getId() . " has been updated",$game);
            $response->write(json_encode($svcresponse));
        }
        catch (Exception $e) {
            $logger->error("PUT /" . $e->getTraceAsString() );
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        
    }
}
?>