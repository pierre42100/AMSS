<?php
/**
 * Config access helpers
 *
 * @author Pierre HUBERT
 */

/**
 * Get the website URL
 *
 * @param String $path_URI Optionnal, defines an URI which will be added to the URL
 * @return String URL to website
 */
function site_url($pathURI=""){
    return amss::getInstance()->config->get("site_url").$pathURI;
}

/**
 * Get website name
 *
 * @return String
 */
function site_name(){
    return amss::getInstance()->config->get("site_name");
}