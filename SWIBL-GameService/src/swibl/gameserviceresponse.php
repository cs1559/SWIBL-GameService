<?php
namespace swibl;

use cjs\lib\BaseObject;
use cjs\lib\ServiceResponse;

/**
 * GameServiceReponse
 * This class is an implementation of the ServiceResponse class returned by the GameService to ensure that the data
 * returned will always contain a Game Object in the response.
 *
 * @link      https://www.swibl-baseball.org
 * @copyright Copyright (c) 2017 Chris Strieter
 * @license   
 *
 */
 
class GameServiceResponse extends ServiceResponse {
    
     /**
     * The constructor will build a Service Response object accepting a Game object as an argument.  This will
     * ensure that the "data" within the repsonse message will always bean instance of a Game.
     * 
     * @param Game $content
     */
    public function __construct(Game $content)
    {
        $this->data = $content;
    }

    public function getData()
    {
        return $this->data;
    }

    
}