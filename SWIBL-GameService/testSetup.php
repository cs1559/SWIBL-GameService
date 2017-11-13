<?php

use cjs\lib\DateUtil;
use cjs\lib\logger\FileLogger;
use swibl\GamesDAO;
use swibl\GameService;

require __DIR__.'/src/cjs/lib/baseobject.php';
require __DIR__.'/src/cjs/lib/application.php';
require __DIR__.'/src/swibl/gameservice.php';
require __DIR__.'/src/cjs/lib/objectbuilder.php';
require __DIR__.'/src/cjs/lib/dateutil.php';
require __DIR__.'/src/swibl/game.php';
require __DIR__.'/src/swibl/gamesdao.php';
require __DIR__.'/src/swibl/gamebuilder.php';

require __DIR__.'/src/cjs/lib/database.php';
require __DIR__.'/src/cjs/lib/config.php';
require __DIR__.'/src/cjs/lib/property.php';
require __DIR__.'/src/cjs/lib/logger/logger.php';
require __DIR__.'/src/cjs/lib/logger/filelogger.php';

$service = GameService::getInstance();
$db = $service->getDatabase();
$jsonGame = file_get_contents("game.json");
$obj = json_decode($jsonGame);
 $builder = new swibl\GameBuilder();
 $game = $builder->build($obj);
 print_r($game);
 exit;
 
   $chkdate = "2018-01-23";
  
  $date = DateUtil::dateConvertForInput($chkdate);
  echo "\r\n";
  echo $date;
  $date = DateUtil::dateConvertForOutput($chkdate);
  echo "\r\n";
  echo $date;
  exit;
  
//   switch (true) {
//       case preg_match('/\d{4}-\d{2}-\d{2}/',$chkdate):
//           echo "Correct Format";
//       case preg_match('/\d{2}-\d{2}-\d{4}/',$chkdate):
//           echo "incorrect format";
//       default:
//           echo "default";
//   }
  
//  if(preg_match('/\d{4}-\d{2}-\d{2}/',$chkdate)){
//      echo "yyyy-mm-dd format";
//  } elseif (preg_match('/\d{2}-\d{2}-\d{4}/',$chkdate)) {
//      echo "mm-dd-yyyy format";
//  }
 
//  echo $game->getGameDate();
//  echo $game->getGameTime();
//  echo date('Y-m-d H:i:s',strtotime($game->getGameDate()));
 exit;
 
 
 $dao = GamesDAO::getInstance($db);
 $dao->update($game);
 print_r($game);
exit;


    $app = \swibl\GameService::getInstance();
    $config = $app->getConfig();
    $filename = $config->getPropertyValue("logfile");
    
    $flog = FileLogger::getInstance($filename);
    $flog->info("hello world");
    exit;
    

    print_r($config);
    exit;
    
    $db = $app->getDatabase();
    echo get_class($db);
    print_r($db);
    
    die;