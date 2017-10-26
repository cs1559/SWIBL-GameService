<?php
namespace cjs\lib;

class Factory {
    
    function getDatabase() {
        $parms["driver"] = "MySQL";
        $parms["host"] = "127.0.0.1";
        $parms["database"] = "games";
        $parms["user"] = "swibl";
        $parms["password"] = "bas3!ball";
        
        $db = & Database::getInstance($parms);
        return $db;
    }
    
}