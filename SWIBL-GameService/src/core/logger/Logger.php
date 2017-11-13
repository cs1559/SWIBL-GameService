<?php
namespace swibl\core\logger;

abstract class Logger {
    
    var $level = 1;
    var $enabled = 1;
    
    /**
     * @return the $enabled
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param number $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return the $level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param number $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    abstract function info($msg);
    abstract function warning($msg);
    abstract function error($msg);
    abstract function critcal($msg);
    abstract function write($msg);
    abstract function debug($msg);
    
}