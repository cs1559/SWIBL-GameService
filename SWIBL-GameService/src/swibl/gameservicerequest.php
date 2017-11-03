<?php
namespace swibl;

use cjs\lib\BaseObject;
use cjs\lib\ServiceRequest;

class GameServiceRequest extends ServiceRequest {
    
    var $game = null;
    
    public function setData(Game $data)
    {
        echo get_class($data);
        $this->setData($data);
    }

    
}