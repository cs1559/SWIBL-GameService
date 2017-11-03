<?php

use cjs\lib\logger\FileLogger;

require __DIR__.'/src/cjs/lib/application.php';
require __DIR__.'/src/swibl/gameservice.php';
require __DIR__.'/src/cjs/lib/database.php';
require __DIR__.'/src/cjs/lib/config.php';
require __DIR__.'/src/cjs/lib/property.php';
require __DIR__.'/src/cjs/lib/logger/logger.php';
require __DIR__.'/src/cjs/lib/logger/filelogger.php';

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