<?php
/**
 * URL functions of the service
 *
 * @author Pierre HUBERT
 */

/**
 * Return current page URL
 *
 * @return String The current URL
 */
function getCurrentURL(){

    //Compose URL and return it
    return $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

}