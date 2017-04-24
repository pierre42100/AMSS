<?php
/**
 * Errors functions - This file let errors being shown
 * to users and get an appropriate behaviour then.
 *
 * @author Pierre HUBERT
 */

/**
 * Handle a fatal error. There are two steps :
 * 1. Show the error
 * 2. Quit the script
 *
 * @param String $errorContent The content of the fatal error
 * @return void
 */
function fatal_error($errorContent) : void {

    //First, display error
    echo "<b>Fatal error: </b> A fatal error has just occured. The message ",
    "of the error is the following : <br /><i>",$errorContent,"</i> <br />",
    "Unfortunately, the page cannot continue to load. We are sorry for the convenience.";

    //Exit script
    exit();

}

/**
 * Display an HTML fatal error
 *
 * @param String $errorMessage The message of the fatal error
 * @return void
 */
function html_fatal_error($errorMessage){
    //Include view file
    http_response_code(500);
    include(PAGES_PATH."common/views/errors/v_fatal_error.php");
    exit();
}

/**
 * Handle and show a Rest fatal error
 *
 * @param Integer $errorCode The error code
 * @param String $message The message of the error
 * @return Nothing
 */
function Rest_fatal_Error($errorCode, $message){
    //Headers
    http_response_code($errorCode);
    header("Content-Type: text/plain;charset=UTF-8");

    echo json_encode(array(
        "error" => array(
            "code"=>$errorCode,
            "message" => $message,
        )
    ));

    //Quit script
    exit();
}