<?php
namespace swibl\services\games;


use swibl\core\Application;
use swibl\core\Config;
use swibl\core\Database;
use swibl\core\logger\FileLogger;

/**
 * GameSerivce is an application instance that provices access to specific application configuration settings.
 * 
 * @author Admin
 *
 */
class GameService extends Application {
    
    private $config = null;
    private $database = null;
    private $logger = null;

    private function __construct() {  }
    
    static function getInstance() {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new self();
            $instance->init();
        }
        return $instance;
    }
    
    /**
     * Initialize the serivce/application.
     * 
     * {@inheritDoc}
     * @see \cjs\lib\Application::init()
     */
    public function init()
    {
        // Read the configuration file
        $ini = parse_ini_file('config.ini');
        
        $this->config = new Config();
        foreach ($ini as $name => $value) {
            $this->config->addProperty($name, $value);
        }
 
        // Establish database connection 
        $parms = array();
        $parms["driver"] = $ini["driver"];
        $parms["host"] = $ini["host"];
        $parms["database"] = $ini["database"];
        $parms["user"] = $ini["user"];
        $parms["password"] = $ini["password"];
        $db = & Database::getInstance($parms);
        $this->setDatabase($db);
        
        // Create the logger
        $logfile = $this->config->getPropertyValue("log.file");
        $logger = FileLogger::getInstance($logfile);
        $logger->setLevel($this->config->getPropertyValue("log.level"));
        $logger->setEnabled($this->config->getPropertyValue("log.enabled"));
        $this->logger = $logger;
    }
    
    /**
     * REturn the Version  of the service.
     * {@inheritDoc}
     * @see \cjs\lib\Application::getVersion()
     */
    public function getVersion()
    {
        return "0.1";
    }

    /**
     * Sets the database object used by objects to retreive game data.
     * @param unknown $db
     */
    private function setDatabase($db) {
        $this->database = $db;
    }
    /*
     * REturns a database instance for this service.
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /*
     * REturn the name of the Service.
     */
    public function getName()
    {
        return "GameService";
    }

    /**
     * REturns an instance of the configuration
     */
    public function getConfig()
    {
        return $this->config;
    }
    /*  
     * REturns the logger for the service.
     * @returns FileLogger
     * */
    public function getLogger()
    {
        return $this->logger;
    }
    
    /**
     * Method to indicate if logging is on for the service.
     * @return boolean
     */
    public function isLogEnabled() {
        $config = $this->config;    
        return $config->getPropertyValue("log.enabled");
    }
    
    /**
     * Method to indicate if API authentication is enabled for this service.
     */
    public function isAuthenticationEnabled() {
        $config = $this->config;
        return $config->getPropertyValue("authentication.enabled");
    }
    
    
}
