<?php
/**
 * RestServer main controller
 * 
 * @author Pierre HUBERT
 */

/**
 * Page initiator
 */
require(__DIR__."/system/init.inc.php");

/**
 * RestServer inclusion
 */
require(SYSTEM_PATH."RestServer/RestServer.php");

/**
 * Security check
 */
//If the user is logged in, everything is OK, else we must check tokens
if(!$amss->user->userLoggedIn()){
    //We check tokens (if there is)
    if(!isset($_POST['token1']) OR !isset($_POST['token2'])){
        Rest_fatal_Error(401, "Please login!");
    }
        
    if(!$amss->user->checkTokens($_POST['token1'], $_POST['token2'])){
        Rest_fatal_Error(401, "Access denied!");
    }
}

/**
 * Create RestServer object
 */
$siteState = $amss->config->get("site_mode");
$server = new \Jacwright\RestServer\RestServer($siteState);

/**
 * Auto-load controllers
 */
foreach(glob(SYSTEM_PATH."RestServerControllers/*.php") as $file_name){
    //Determine classname
    $classname = str_replace(
        array(".php", "Controllers/"), 
        "", 
        strstr($file_name, "Controllers")
    );
    
    //Require class and include it
    require($file_name);
    $server->addClass($classname);
}

/**
 * Handle request
 */
$server->handle();