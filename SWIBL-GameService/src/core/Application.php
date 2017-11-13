<?php
namespace swibl\core;

/**
 * This is an abstract "application" class that defines the required functions that need to be implemented
 * by the concrete implentations.  The application class will source the name/version of the service or application,
 * return the configuration, logger and the database associated with application.
 * 
 * @author Admin
 *
 */
abstract class Application {
    
    abstract public function init();
    abstract public function getName();
    abstract public function getVersion();
    abstract public function getConfig();
    abstract public function getDatabase();
    abstract public function getLogger();
    
}