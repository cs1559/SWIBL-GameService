<?php
namespace swibl;

use cjs\lib\Config;
use cjs\lib\logger\FileLogger;

/**
 * GameSerivce is an application instance that provices access to specific application configuration settings.
 * 
 * @author Admin
 *
 */
class GameService extends \cjs\lib\Application {
    
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
        $db = & \cjs\lib\Database::getInstance($parms);
        $this->setDatabase($db);
        
        // Create the logger
        $logfile = $this->config->getPropertyValue("log.file");
        $logger = FileLogger::getInstance($logfile);
        $this->logger = $logger;
    }
    
    public function getVersion()
    {
        return "0.1";
    }

    private function setDatabase($db) {
        $this->database = $db;
    }
    public function getDatabase()
    {
        return $this->database;
    }

    public function getName()
    {
        return "GameService";
    }

    public function getConfig()
    {
        return $this->config;
    }
    /*  
     * @returns FileLogger
     * */
    public function getLogger()
    {
        return $this->logger;
    }
    
    public function isLogEnabled() {
        $config = $this->config;    
        return $config->getPropertyValue("log.enabled");
    }
    
    
}
