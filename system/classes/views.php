<?php
/**
 * View managment and registering class
 *
 * @author Pierre HUBERT
 */

/**
 * This class enables views registering for latter use.
 *
 * @author Pierre HUBERT
 */
class views {
    /**
     * Record view files listing + data about views in right order
     *
     * @var Array $viewsListing
     */
    private $viewsListing = array();
    
    /**
     * Class public constructor
     */
    public function __construct(){

    }

    /**
     * Register a new view in view listing
     *
     * @param String $viewLocation Specify where the view will have to be rendered (body / bottom)
     * @param String $filePath Relative path to view file
     * @param Array $viewDatas Datas to pass to view file
     * @return Boolean True for a success
     */
    public function load($viewLocation, $filePath, array $viewDatas=array()){
        //Check if specified file exists
        if(!file_exists($filePath)){
            //It is a fatal error
            html_fatal_error("Requested view file: ".$filePath." couldn't be found !");
        }

        //Import array variables
        extract($viewDatas, EXTR_SKIP);

        //Start to buffer output
        ob_start();

        //Execute source code
        include($filePath);

        //Get buffer content then buff the flusher
        $output = ob_get_contents();
        ob_end_clean();

        //Check if view listing is ready to receive view generated source code
        if(!isset($this->viewsListing[$viewLocation])){
            //Then initialize it
            $this->viewsListing[$viewLocation] = array();
        }

        //Save content at the appropriate location
        $this->viewsListing[$viewLocation][]=$output;

        //Destroy created variables (security)
        foreach($viewDatas as $varname=>$i){
            unset($varname); //Destroy variable
        }

        //Everything seems to be OK
        return true;
    }

    
    /**
     * Returns generated source code for a specified location
     *
     * @param String $viewLocation The target location
     * @return String The source code (empty if there isn't anything)
     */
    public function get($viewLocation){
        //If $this->viewListing is empty, it means that there isn't anything to show
        if(!isset($this->viewsListing[$viewLocation]))
            return ""; //Returns empty string
        
        //Else we implode all the elements of the array containing sources and we return it
        return implode($this->viewsListing[$viewLocation]);
    }
}