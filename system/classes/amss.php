<?php
/**
 * Main AMSS contener class
 *
 * @author Pierre HUBERT
 */

/**
 * This class can be considered as the main parent
 * class of the project.
 */
class amss {
    /**
     * @var Object Reference to this object
     */
     private static $instance;

    /**
     * Public constructor of the class
     */
    public function __construct(){
        //Get current instance of object and save it as self object
        self::$instance =& $this;
    }

    /**
     * Add an object to the AMSS class
     *
     * @param String $name The name of the object to add
     * @param Object $object The object to add in amss object
     */
     public function register($name, $object){
         //Register object
         $this->{$name} = &$object;

         //Specify in object reference to parent
         $object->parent = &$this;
     }

     /**
      * Returns current object
      *
      * @static
      * @return object - central object
      */
      public static function getInstance(){
          return self::$instance;
      }
}