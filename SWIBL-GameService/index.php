<?php

/**
 * This is the 
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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
 * /games/{id}
 * /games/schedule/{teamid}?season=
 */

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        
    ],
];

$app = new \Slim\App($config);


$app->get('/{id}', function (Request $request, Response $response) {

    $dao = new swibl\GamesDAO();
    $game = $dao->getGame($request->getAttribute('id'));

    if($game) {
        $response->withHeader('Content-Type', 'application/json');
        $response->write(json_encode($game));
        
    } else { throw new Exception('No records found');}
    
    return $response;
});
    
    
$app->get('/schedule/{teamid}', function (Request $request, Response $response, $args) {
        
        
        $uri = $request->getUri();
        
        $params = $request->getQueryParams();

        if (isset($params["season"])){
            $season = $params["season"];
        } else {
            $svcresponse = new cjs\lib\ServiceResponse();
            $error = new cjs\lib\Error();
            $error->setReference("URL=".$uri);
            $error->setUserMessage("Missing key parameter - NO SEASON ID provided");
            $error->setMethod("index.php");
            $svcresponse->addError($error);
            $body = $response->getBody();
            $body->write(json_encode($svcresponse));
            return $response->withStatus(500)->withHeader('Content-type', 'application/json')->withBody($body);
        }
        
        $teamid = $request->getAttribute("teamid");
        $dao = new swibl\GamesDAO();
        $games = $dao->getGameSchedule($teamid, $season);
        
//         $db = cjs\lib\Factory::getDatabase();
//         $db->setQuery("select * from joom_jleague_scores where season = " . $season . " and (awayteam_id = " . $teamid . " or hometeam_id = " . $teamid . ")");
//         $games = $db->loadObjectList();
        
        if($games) {
            $response->withHeader('Content-Type', 'application/json');
            $response->write(json_encode($games));
            
        } else { throw new Exception('No records found');}
        
        return $response;
    });
    
    $app->get('/{id}?upcoming={games}', function (Request $request, Response $response) {
 
        echo "getting upcoiming gameS";
        die;
//         $dao = new swibl\GamesDAO();
//         $game = $dao->getGame($request->getAttribute('id'));
        
        if($game) {
            $response->withHeader('Content-Type', 'application/json');
            $response->write(json_encode($game));
            
        } else { throw new Exception('No records found');}
        
        return $response;
    });
        
    
    
$app->run();