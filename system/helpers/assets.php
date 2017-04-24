<?php
/**
 * Assets helpers
 *
 * @author Pierre HUBERT
 */

/**
 * Returns the path to an asset
 *
 * @param String $assetURI Optionnal, the URI pointing on asset
 * @return String
 */
function path_assets($assetURI = ""){
    return site_url("assets/".$assetURI);
}

/**
 * Returns the path to an image asset
 *
 * @param String $imgURI Optionnal, the URI pointing on the image
 * @return String
 */
function img_asset($imgURI=""){
    return path_assets("img/".$imgURI);
}

/**
 * Returns the path to a javasript asset
 *
 * @param String $jsURI Path to the javascript file (required)
 * @return String
 */
function js_asset($jsURI){
    return path_assets("js/".$jsURI.".js");
}

/**
 * Returns the path to a CSS asset
 *
 * @param String $cssURI Path to the CSS file (required)
 * @return String
 */
function css_asset($jsURI){
    return path_assets("css/".$jsURI.".css");
}

/**
 * Include a javascript assset file
 *
 * @param String $jsURI Path to the javascript file (required)
 * @return String
 */
function inc_js_asset($jsURI){
    return incJScode(js_asset($jsURI));
}

/**
 * Include a CSS assset file
 *
 * @param String $cssURI Path to the CSS file (required)
 * @return String
 */
function inc_css_asset($cssURI){
    return incCSScode(css_asset($cssURI));
}


/**
 * Returns source code to include a Javascript file
 *
 * @param String $jsURL URL pointing on JS file
 * @return String
 */
function incJScode($jsURL){
    return "<script src='".$jsURL."' type='text/javascript'></script>";
}


/**
 * Returns source code to include CSS file
 *
 * @param String $cssURL URL pointing on CSS file
 * @return String
 */
function incCSScode($cssURL){
    return "<link rel='stylesheet' href='".$cssURL."' />";
}