<?php
namespace swibl\core;

abstract class Factory {

    abstract function getApplication();
    abstract function getDatabase();

//         $parms = array();
//         $parms["driver"] = "MySQL";
//         $parms["host"] = "127.0.0.1";
//         $parms["database"] = "games";
//         $parms["user"] = "swibl";
//         $parms["password"] = "bas3!ball";
        
//         $db = & Database::getInstance($parms);
//         return $db;
    
    
}