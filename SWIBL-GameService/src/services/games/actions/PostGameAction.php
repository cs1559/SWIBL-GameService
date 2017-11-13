<?php
namespace swibl\services\games\actions;


use Slim\Container;
use Exception;
use swibl\services\games\GameBuilder;
use swibl\services\games\GameService;
use swibl\services\games\GameServiceResponse;
use swibl\services\games\GamesDAO;

class PostGameAction
{
    protected $container;
    
    public function __construct(Container $container) {
        $this->container = $container;
    }
    
    public function __invoke($request, $response, $args) {
        
        $service = GameService::getInstance();
        $body = $request->getBody();
        $content = $body->getContents();
        
        $logger = $service->getLogger();
        $logger->info("POST /" . $content );
        
        //         $content2 = $request->getParsedBody();
        
        $dao = GamesDAO::getInstance($service->getDatabase());
        try {
            $builder = new GameBuilder();
            $logger->debug("REQUEST CONTENT: " . $content);
            $game = $builder->build(json_decode($content));
            $newid = $dao->insert($game);
            $game->setId($newid);
            $svcresponse = new GameServiceResponse(200, "Record " . $newid . " has been created",$game);
            //             $svcresponse->setCode(200);
            //             $svcresponse->setMessage("Record " . $newid . " has been created");
            $response->write(json_encode($svcresponse));
        }
        catch (Exception $e) {
            $logger->error("POST /" . $e->getTraceAsString() );
            $svcresponse = new GameServiceResponse(400, $e->getMessage());
            $response->write(json_encode($svcresponse));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        
        
    }
}
?>