<?php

/**
 * This is the main contorller for the GameService.
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use swibl\GameBuilder;
use swibl\GameServiceResponse;
use swibl\GameService;

require 'vendor/autoload.php';

// Bootstrap the service
if (file_exists('bootstrap.php'))
{
    include_once 'bootstrap.php';
}

// Routes
/* TEST DATA
 * GameID = 18737
 * TeamID = 697
 * Season = 20
 */
/*
 * ROUTES
 *
 * /{id}
 * /schedule/{teamid}?season=
 * /update/{id}
 * /dashboard/
 *
 */

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        
    ],
];

$app = new \Slim\App($config);
$app->add(new swibl\RequestAuthorizer());

$app->get('/{id}', function (Request $request, Response $response) {
    
    //     $body = $request->getBody()->getContents();
    //     echo "body = " . $body;
    //     exit;
    
    
    $service = GameService::getInstance();
    
    if ($service->isLogEnabled()) {
        $logger = $service->getLogger();
        $logger->info("GET /" . $request->getAttribute('id') );
    }
    $dao = \swibl\GamesDAO::getInstance($service->getDatabase());
   
    $headers = $request->getHeaders();
    foreach ($headers as $name => $values) {
         $logger->write($name . ": " . implode(", ", $values));
     }

    try {
        $result = $dao->getGame($request->getAttribute('id'));
        $builder = new GameBuilder();
        $game = $builder->build($result);
        
        $svcresponse = new GameServiceResponse($game);
        $svcresponse->setCode(200);
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
});
    
    
    /**
     * This ROUTE will retrieve a game schedule for a team and a specific season
     */
    $app->get('/schedule/{teamid}', function (Request $request, Response $response, $args) {
        
        
        $uri = $request->getUri();
        
        $params = $request->getQueryParams();
        
        if (isset($params["season"])){
            $season = $params["season"];
        } else {
            $svcresponse = new GameServiceResponse();
            $svcresponse->setCode(400);
            $svcresponse->setMessage("Season ID is missing from the request - " . "GET /schedule/{teamid}");
            $response->write(json_encode($svcresponse));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
        
        $teamid = $request->getAttribute("teamid");
        $dao = new swibl\GamesDAO();
        try {
            $results = $dao->getGameSchedule($teamid, $season);
            $games = \swibl\GameHelper::bindArray($results);
            $svcresponse = new GameServiceResponse();
            $svcresponse->setCode(200);
            $svcresponse->setData($games);
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
    });
        
        
        $app->put('/{id}', function (Request $request, Response $response) {
            
            $service = GameService::getInstance();
            
            $id = $request->getAttribute("id");
            $body = $request->getBody();
            $content = $body->getContents();
            
            $content2 = $request->getParsedBody();
            if ($service->isLogEnabled()) {
                $logger = $service->getLogger();
                $logger->info("PUT /" . $content );
            }
            
            $dao = \swibl\GamesDAO::getInstance($service->getDatabase());
            try {
                $builder = new GameBuilder();
                $logger->write( $content);
                $game = $builder->build(json_decode($content));
                $dao->update($game);
            }
            catch (Exception $e) {
                if ($service->isLogEnabled()) {
                    $logger = $service->getLogger();
                    $logger->write("Exception occured");
                    $logger->info("PUT /" . $e->getTraceAsString() );
                }
                $svcresponse = new GameServiceResponse();
                $svcresponse->setCode(200);
                $svcresponse->setMessage("WITHIN UPDATE ROUTINE");
                $response->write(json_encode($svcresponse));
            }
            
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        });
            
            
            $app->post('/', function (Request $request, Response $response) {
                
                /*
                 $service = GameService::getInstance();
                 
                 $id = $request->getAttribute("id");
                 $body = $request->getBody();
                 $content = $body->getContents();
                 
                 $content2 = $request->getParsedBody();
                 if ($service->isLogEnabled()) {
                 $logger = $service->getLogger();
                 $logger->info("PUT /" . $content );
                 }
                 
                 $dao = \swibl\GamesDAO::getInstance($service->getDatabase());
                 try {
                 $builder = new GameBuilder();
                 $logger->write( $content);
                 $game = $builder->build(json_decode($content));
                 $dao->update($game);
                 }
                 catch (Exception $e) {
                 if ($service->isLogEnabled()) {
                 $logger = $service->getLogger();
                 $logger->write("Exception occured");
                 $logger->info("PUT /" . $e->getTraceAsString() );
                 }
                 $svcresponse = new GameServiceResponse();
                 $svcresponse->setCode(200);
                 $svcresponse->setMessage("WITHIN UPDATE ROUTINE");
                 $response->write(json_encode($svcresponse));
                 }
                 
                 return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
                 */
            });
                
                $app->delete('/{id}', function (Request $request, Response $response) {
                    
                    /*
                     $service = GameService::getInstance();
                     
                     $id = $request->getAttribute("id");
                     $body = $request->getBody();
                     $content = $body->getContents();
                     
                     $content2 = $request->getParsedBody();
                     if ($service->isLogEnabled()) {
                     $logger = $service->getLogger();
                     $logger->info("PUT /" . $content );
                     }
                     
                     $dao = \swibl\GamesDAO::getInstance($service->getDatabase());
                     try {
                     $builder = new GameBuilder();
                     $logger->write( $content);
                     $game = $builder->build(json_decode($content));
                     $dao->update($game);
                     }
                     catch (Exception $e) {
                     if ($service->isLogEnabled()) {
                     $logger = $service->getLogger();
                     $logger->write("Exception occured");
                     $logger->info("PUT /" . $e->getTraceAsString() );
                     }
                     $svcresponse = new GameServiceResponse();
                     $svcresponse->setCode(200);
                     $svcresponse->setMessage("WITHIN UPDATE ROUTINE");
                     $response->write(json_encode($svcresponse));
                     }
                     
                     return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
                     */
                });
                    
                    $app->run();
                    
                    
                    