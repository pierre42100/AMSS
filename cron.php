<?php
/**
 * Cron file
 * The aim of this file is to send automatically mails on regular time
 * and perform other regular tasks
 *
 * @author Pierre HUBERT
 */

/**
 * Initializate the page
 */
require(__DIR__."/system/init.inc.php");

/**
 * Security - Opening this file from a browser is prohibited
 */
if(isset($_SERVER['HTTP_HOST'])){
    //The error code is the unique indication we'll give to user
    http_response_code(401);

    //But we log the error
    $amss->log->logMessage(__FILE__, "ACCESS DENIED - Trying to run cron job from a browser !");

    //Now we quit script
    exit();
}

/**
 * Try to send a mail
 */
if(!$amss->mails->isThereMailToSend()){
    //There isn't any mail to be sent
    $amss->log->logMessage(__FILE__, "There isn't any mail to send.");
}
elseif($amss->mails->sendAmail()){
    //A mail was sent
    $amss->log->logMessage(__FILE__, "A mail was sent.");
}
else {
    //An error happened
    $amss->log->logMessage(__FILE__, "ERROR - An error occurred while trying to send a mail !");
}

/**
 * Clean logs
 */
if(!$amss->log->clean()){
    //Couldn't clean logs
    $amss->log->logMessage(__FILE__, "ERROR - Couldn't clean log folder.");
}
else{
    $amss->log->logMessage(__FILE__, "Log folder was cleaned.");
}