<?php
/**
 * Configuration class
 *
 * Makes configurations data easily accessible
 *
 * @author Pierre HUBERT
 */

class Config {

    /**
     * @var Array $configValues Values of the configuration
     */
     private $configValues = array();

    /**
     * Class constructor 
     */
     public function __construct(){
         //Nothing now
     }

     /**
      * Set a new config elem (or update one)
      *
      * @param String $name The name of the element
      * @param String $value The value of config element
      * @return Boolean True if success
      */
      public function set($name, $value){
          //Save new value
          $this->configValues[$name] = $value;

          //Done
          return true;
      }

      /**
       * Get a config element
       *
       * @param String $name The name of the config element to get
       * @return Mixed The requested value or false if it fails
       */
       public function get($name){
           //Check value
           if(!isset($this->configValues[$name])){
               throw new Exception("The requested config value : '".$name."' doesn't exists ");
               return false;
           }

           //Else we can return the value
           return $this->configValues[$name];
       }

}