<?php
namespace cjs\lib\logger;

abstract class Logger {
    
    var $level = 1;
    
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
    
}