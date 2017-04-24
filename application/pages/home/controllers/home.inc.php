<?php
/**
 * Project home main controller
 *
 * @author Pierre HUBERT
 */

//Register parent folder as main home folder
define("HOME_PAGE_DIR", str_replace("controllers", "", __DIR__));

//Load main home view file
$amss->views->load("body", HOME_PAGE_DIR."views/v_home.php");

//Load end page scripts
$amss->views->load("endPageScripts", HOME_PAGE_DIR."views/v_endScripts.php");