<?php
namespace swibl\services\games;


use swibl\core\ServiceRequest;

class GameServiceRequest extends ServiceRequest {
    
    var $game = null;
    
    public function setData(Game $data)
    {
        echo get_class($data);
        $this->setData($data);
    }

    
}