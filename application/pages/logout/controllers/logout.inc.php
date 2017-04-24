<?php
/**
 * Logout main controller
 *
 * @author Pierre HUBERT
 */

//Logout and then redirect to the main login controller
$amss->user->logout();

header("Location: ".$amss->config->get("site_url")."login");
exit("User logouted !");