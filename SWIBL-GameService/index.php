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

// Service Routes
$app->get('/{id}', \swibl\actions\GetGameAction::class); 
$app->get('/schedule/{teamid}/season/{seasonid}', \swibl\actions\GetTeamScheduleAction::class);
$app->put('/{id}', \swibl\actions\PutGameAction::class);
$app->post('/', \swibl\actions\PostGameAction::class);
$app->delete('/{id}', \swibl\actions\DeleteGameAction::class);
$app->get('/schedule/{teamid}/season/{seasonid}/download', \swibl\actions\DownloadScheduleAction::class);
                            
$app->run();
                    
                    
                    