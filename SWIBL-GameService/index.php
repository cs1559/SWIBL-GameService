<?php

/**
 * This is the main contorller for the GameService.
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use swibl\services\games\GameBuilder;
use swibl\services\games\GameServiceResponse;
use swibl\services\games\GameService;
use swibl\services\games\actions\DeleteGameAction;
use swibl\services\games\actions\DownloadScheduleAction;
use swibl\services\games\actions\GetGameAction;
use swibl\services\games\actions\GetTeamScheduleAction;
use swibl\services\games\actions\PostGameAction;
use swibl\services\games\actions\PutGameAction;
use swibl\services\games\GameRequestAuthorizer;

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
$app->add(new GameRequestAuthorizer());

// Service Routes
$app->get('/{id}', GetGameAction::class); 
$app->get('/schedule/{teamid}/season/{seasonid}', GetTeamScheduleAction::class);
$app->put('/{id}', PutGameAction::class);
$app->post('/', PostGameAction::class);
$app->delete('/{id}', DeleteGameAction::class);
$app->get('/schedule/{teamid}/season/{seasonid}/download', DownloadScheduleAction::class);
                            
$app->run();
                    
                    
                    