<?php
namespace swibl\core\logger;

class FileLogger extends Logger {
    
    private $filename = null;
    
    private function __construct() {  }
    
    static function getInstance($filename) {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new self();
            $instance->setFilename($filename);
        }
        return $instance;
    }
    
    private function setFilename($fn) {
        $this->filename = $fn;
    }
    private function getFilename() {
        return $this->filename;
    }
    public function warning($msg)
    {
        $this->write("[WARNING] " . $msg);
    }

    public function critcal($msg)
    {
        $this->write($msg);
    }

    public function error($msg)
    {
        $this->write("[ERROR] " . $msg);
    }

    public function write($msg)
    {
        if (!$this->isEnabled()) {
            return;
        }
        $time = @date('[d/M/Y:H:i:s]');
        
        // open file
        $fd = fopen($this->getFilename(), 'a');
        
        // write string
        fwrite($fd, $time . " " . $msg . PHP_EOL);
        
        // close file
        fclose($fd);
    }
    
    public function debug($msg) {
        if ($this->getLevel() > 2) {
            $this->write("[DEBUG] " . $msg);
        }
        return;
    }

    public function info($msg)
    {
        $this->write("[INFO] " . $msg);
    }

    
}