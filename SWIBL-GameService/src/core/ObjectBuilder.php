<?php
namespace swibl\core;

abstract class ObjectBuilder {
  
    /**
     * The build method is an abstract function that all subclasses must implement. 
     * 
     * @param unknown $result
     */
    abstract function build($result);   
  
     /**
       * The map function will accept three (3) arguments and build the object with values from the array based on the map.
       * 
       * @param unknown $array - This represents the query results 
       * @param unknown $map - This is an array of table column names (in an array) and the corresponding method used to set the objects value
       * @param unknown $object - a reference to the object being populated.
       * @throws Exception
       */
      protected function map($array, $map, &$object) {
          
          try {
              // Convert result object to an array
              $objVars = get_object_vars($array);
              
              foreach ($map as $field => $method) {
                  if (isset($objVars[$field]))
                      $object->$method($objVars[$field]);
              }
              $object->setObjectState(true);
          } catch (\Exception $e) {
              throw $e;
          }
      }
}