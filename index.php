<?php

/* 
 * The MIT License
 *
 * Copyright 2017 pierre.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Main project file
 * 
 * @author Pierre HUBERT
 */

//Init AMSSS system
require(__DIR__."/system/init.inc.php");

//Determine which page should be opened
$currentURL = getCurrentURL();
$siteURL = $amss->config->get("site_url");
$page = str_replace($siteURL, "", $currentURL);
if(preg_match("/\?/", $page))
    $page = strstr($page, "?", true);
if(preg_match("</>", $page))
    $page = strstr($page, "/", true);

//If no page was specified, using default one
$page = ($page == "" ? "home" : $page);
$page_basePath = PAGES_PATH.$page."/";

//We check if required page exists or not
if(!file_exists($page_basePath."manifest.json")){
    //404 not found error
    http_response_code(404);
    exit("<b>Error !</b> The requested page was not found...");
}

//If user isn't logged in, the page is automaticaly the login page
if(!$amss->user->userLoggedIn()){
    $page = "login";
    $page_basePath = PAGES_PATH."login/";
}

//Load page manifest
$pageInfos = json_decode(file_get_contents($page_basePath."manifest.json"));

//Check the page doesn't require HTML to be loaded
if(!$pageInfos->needHTML){
    //Include main controller, then exit
    require($page_basePath.$pageInfos->mainController);
    exit();
}

//Else include html page loader
require("application/launch/html_page.php");