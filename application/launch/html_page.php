<?php
/**
 * HTML page loader
 *
 * @author Pierre HUBERT
 */

//Include ressources
$amss->views->load("headScripts", PAGES_PATH."common/views/pageRessources/v_headRessources.php"); //Head ressources
$amss->views->load("endPageScripts", PAGES_PATH."common/views/pageRessources/v_bottomRessources.php"); //Head ressources

//Include javascript configuration, if user logged in
$amss->views->load("headScripts", PAGES_PATH."common/views/pageRessources/v_jsConfig.php"); //Javascript config

//Include menubar, if required
if(isset($pageInfos->needMenubar)){
    if($pageInfos->needMenubar){
        //Get appropriate informations for menubar
        $menubar_infos = array(
            "site_url" => $amss->config->get("site_url"),
            "site_name" => $amss->config->get("site_name"),
            "userInfos" => $amss->user->infos(),
        );

        //Load the view
        $amss->views->load("menubar", PAGES_PATH."common/views/pageStructure/v_menubar.php", $menubar_infos);
    }
}

//Include sidebar, if required
if(isset($pageInfos->needSidebar)){
    if($pageInfos->needSidebar){
        //Get appropriate informations for the sidebar
        $sidebar_infos = array(
            "site_url" => $amss->config->get("site_url"),
        );

        //Load the view
        $amss->views->load("sidebar", PAGES_PATH."common/views/pageStructure/v_sidebar.php", $sidebar_infos);
    }
}

//Include bottom, if required
if(isset($pageInfos->needBottom)){
    if($pageInfos->needBottom){
        //Load the view
        $amss->views->load("bottom", PAGES_PATH."common/views/pageStructure/v_bottom.php");
    }
}

//Check if a wrapper is required
$needWrapper = false;
if(isset($pageInfos->needWrapper)){
    if($pageInfos->needWrapper)
        $needWrapper = true;
}

//Else we start with controller inclusion
require($page_basePath.$pageInfos->mainController);

//Then we start to return HTML page
?><!DOCTYPE html>
<html>
    <head>
        <!-- Page title -->
        <title><?php echo $pageInfos->title; ?> - AMSS</title>

        <!-- Responsive project -->
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=1">

        <!-- Define charset -->
        <meta charset="utf-8">

        <!-- Site icon -->
        <link rel="shortcut icon" href="<?=img_asset("emails.png")?>">

        <!-- Head of page ressources -->
        <?php echo $amss->views->get("headScripts"); ?>
    </head>
    <body <?php echo(isset($pageInfos->body_class) ? "class='".$pageInfos->body_class."'" : ""); ?>>

        <!-- Wrapper, if required -->
        <?=($needWrapper ? "<div class='wrapper'>" : "")?>

        <!-- Menubar -->
        <?php echo $amss->views->get("menubar"); ?>

        <!-- Sidebar -->
        <?php echo $amss->views->get("sidebar"); ?>

        <!-- Main page views sources -->
        <?php echo $amss->views->get("body"); ?>

        <!-- Bottom sources -->
        <?php echo $amss->views->get("bottom"); ?>
 
        <!-- Wrapper, if required (close) -->
        <?=($needWrapper ? "</div>" : "")?>

        <!-- End of page scripts inclusion -->
       <?php echo $amss->views->get("endPageScripts"); ?>
    </body>
</html>