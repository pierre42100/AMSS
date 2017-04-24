<?php
/**
 * Compose a message main controller
 *
 * @author Pierre HUBERT
 */

//Register parent folder as main home folder
define("COMPOSE_PAGE_DIR", str_replace("controllers", "", __DIR__));

//Generate a random mail id
$mailID = time()."-".rand(1,15000);

//We check if a specific message ID was specified
if(isset($_GET['mailID'])){
    if($_GET['mailID'] != ""){
        //Use message ID specified in the request
        $mailID = $_GET['mailID'];
    }
}

//Prepare mail compose form with default data
$mailInfos = array(
    "mail_id"=>$mailID,
    "from_mail"=>$amss->config->get("defaultMailAddress"),
    "from_name"=>$amss->config->get("defaultMailSender"),
    "destination_mail" => "",
    "send_time" => "",
    "send_date" => "",
    "subject" =>"",
    "message"=>$amss->config->get("defaultMessage"),

    //Page defaults
    "pageTitle" => "Compose",
    "pageDescription" => "Compose a new message",
);

//Check if the specified mailID exists or not
if($amss->mails->checkMailExistence($mailID)){
    //Get informations about the mail
    if($mailInfos = $amss->mails->getInformations($mailID)){

        //Duplicate mail_id in the right location
        $mailInfos["mail_id"] = $mailInfos["id"];
        $mailInfos["pageTitle"] = "Edit";
        $mailInfos["pageDescription"] = "Edit an existing message";

        //Done. Nothing to do more (scripts will handle automaticaly other adaptations)
    }
    else{
        //We can't continue this way
        html_fatal_error("Couldn't retrieve informations about an existing mail!");
    }
}

//Load main home view file
$amss->views->load("body", COMPOSE_PAGE_DIR."views/v_compose.php", $mailInfos);

//Load head of page ressources inclusion
$amss->views->load("headScripts", COMPOSE_PAGE_DIR."views/v_beginScripts.php");

//Load end of page ressources inclusion
$amss->views->load("endPageScripts", COMPOSE_PAGE_DIR."views/v_endScripts.php", $mailInfos);