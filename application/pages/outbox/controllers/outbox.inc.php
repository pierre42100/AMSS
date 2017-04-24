<?php
/**
 * Outbox main controller
 *
 * @author Pierre HUBERT
 */

//Register parent folder as main page folder
define("OUTBOX_PAGE_DIR", str_replace("controllers", "", __DIR__));

//Load main outbox view file
$amss->views->load("body", OUTBOX_PAGE_DIR."views/v_outbox.php");

//Load end page elements
$amss->views->load("endPageScripts", OUTBOX_PAGE_DIR."views/v_endScripts.php");