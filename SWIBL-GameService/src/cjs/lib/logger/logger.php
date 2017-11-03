<?php
namespace cjs\lib\logger;

abstract class Logger {
    
    abstract function info($msg);
    abstract function warning($msg);
    abstract function error($msg);
    abstract function critcal($msg);
    abstract function write($msg);
    
}