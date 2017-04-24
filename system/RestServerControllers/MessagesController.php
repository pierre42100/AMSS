<?php
/**
 * REST API messages main controller
 *
 * @author Pierre HUBERT
 */

class MessagesController {
	/**
	 * Save current message state (Insert / Update)
	 *
	 * @url POST api.php/messages/save
	 */
	 public function saveMessage(){
		 //Check and extract fields
		 if(!isset($_POST['message_id']) OR
			!isset($_POST['from_name']) OR
			!isset($_POST['from_mail']) OR
			!isset($_POST['destination_mail']) OR
			!isset($_POST['subject']) OR
			!isset($_POST['datepicker']) OR
			!isset($_POST['timepicker']) OR
			!isset($_POST['message'])){
				//At least one field is missing
				Rest_fatal_Error("401", "Please check your input (some elements are missing) !");
		}
		
		//Extract elements
		$message_id = $_POST['message_id'];
		$from_name = $_POST['from_name'];
		$from_mail = $_POST['from_mail'];
		$destination_mail = $_POST['destination_mail'];
		$subject = $_POST['subject'];
		$datepicker = $_POST['datepicker'];
		$timepicker = $_POST['timepicker'];
		$message = $_POST['message'];

		//Check mail adresses
		if(!filter_var($from_mail, FILTER_VALIDATE_EMAIL) OR !filter_var($destination_mail, FILTER_VALIDATE_EMAIL))
			Rest_fatal_Error("400", "Please check given email addresses !"); //Bad request
		
		//Check expeditor domain
		if(!preg_match("<@".AMSS::getInstance()->config->get("mailDomain").">", $from_mail)){
			Rest_fatal_Error("400", "Please check expeditor mail domain !"); //Bad request
		}
		
		//Check subject and expeditor name
		if(preg_match("<\n>", $subject) ||preg_match("<\n>", $from_name))
			Rest_fatal_Error("400", "Please check your subject or expeditor name (line break not allowded) !"); //Bad request
		
		//Try to save save message
		if(!AMSS::getInstance()->mails->saveMailChanges($message_id, $from_name, $from_mail, $destination_mail, $subject, $message, $datepicker, $timepicker)){
			Rest_fatal_Error("500", "Couldn't save your changes! Please try again later..."); //Error from server
		}

		//Else everything is OK
		return array("success" => "The mail was successfully saved !");
	}

	/**
	 * Plan a mail
	 *
	 * @url POST api.php/messages/plan
	 */
	public function planMail(){
		//Check and extract fields
		if(!isset($_POST['mailID']) OR !isset($_POST['plan']))
			Rest_fatal_Error("401", "At least one field is missing !");

		//Extract fields
		$mailID = $_POST['mailID'];
		$planMail = ($_POST['plan'] == "true" ? true : false);

		//Check if specified mail exists or not
		if(!AMSS::getInstance()->mails->checkMailExistence($mailID))
			Rest_fatal_Error("404", "The specified mail was not found !"); //Mail not found

		//Try to plan mail
		if(!AMSS::getInstance()->mails->plan($mailID, $planMail))
			Rest_fatal_Error("500", "The specified mail couldn't be planned !"); //Mail not found

		//Else everything went good
		return array("success" => "The mail was successfully planned!");
	}

	/**
	 * Retrieve mail list (without the content of the messages)
	 * 
	 * @url POST api.php/messages/getList
	 */
	public function getList(){
		//Check if the content of the messages may be included or not with the list
		$includeMessagesContent = false;
		if(isset($_POST['messagesContent'])){
			if($_POST['messagesContent'] == "true")
				//Then we can include the content of the messages
				$includeMessagesContent = true;
		}

		//Try to retrieve messages list
		if(!$messagesList = AMSS::getInstance()->mails->getList($includeMessagesContent))
			Rest_fatal_Error("500", "Couldn't retrieve messages list !"); //Couldn't get messages list
		
		//If we go there, it is a success, and we can return the list of messages
		return array(
			"success" => "Messages list is included with the response.",
			"messagesList" => $messagesList,
		);
	}

	/**
	 * Get informations about a single message
	 *
	 * @url POST api.php/messages/getInfos
	 */
	public function getInfoOneMessage(){
		//Check if mailID was included in the request
		if(!isset($_POST['mailID']))
			Rest_fatal_Error("401", "No mail ID was specified !"); //MailID is required
		
		//Check if the required mail exists in the database
		$mailID = $_POST['mailID'];
		if(!AMSS::getInstance()->mails->checkMailExistence($mailID))
			Rest_fatal_Error("404", "The specified mail wasn't found in the database !"); //Mail not found
		
		//Now we can try to get informations about the mail
		if(!$mailInfos = AMSS::getInstance()->mails->getInformations($mailID))
			Rest_fatal_Error("500", "Mails informations couldn't be retrieved! Please try again later..."); //Internal error
		
		//We can now return informations about the mail
		return array(
			"success" => "The mail was found in the database",
			"mailInformations" => $mailInfos,
		);

	}

	/**
	 * Delete a mail
	 *
	 * @url POST api.php/messages/delete
	 */
	public function deleteMail(){
		//Check if required fields are present in the message
		if(!isset($_POST['mailID']) OR !isset($_POST['confirm']))
			Rest_fatal_Error("401", "At least one field is missing !");
		
		//Extract and check data
		if($_POST['confirm'] != "true")
			Rest_fatal_Error("401", "Please confirm the request !");
		
		//Check mailID
		$mailID = $_POST['mailID'];
		if(!AMSS::getInstance()->mails->checkMailExistence($mailID))
			Rest_fatal_Error("404", "The mail to delete was not found !"); //Mail not found
		
		//Now we can delete the mail
		if(!AMSS::getInstance()->mails->delete($mailID))
			Rest_fatal_Error("500", "Couldn't delete the mail !"); //Internal error

		//If we are here, the message may have been successfully delete
		return array("success" => "The message was successfully deleted!");
	}
 
	/**
	 * Send a message (if any)
	 *
	 * @url POST api.php/messages/sendOne
	 */
	public function sendAmessage(){
		//Check if there is a mail ready to be sent
		if(!AMSS::getInstance()->mails->isThereMailToSend())
			return array("success" => "There isn't any mail ready to be sent"); //Nothing to be done for now
		
		//Try to send a mail (because now we now there are mail ready to be sent)
		if(!AMSS::getInstance()->mails->sendAmail())
			Rest_fatal_Error("500", "Couldn't send a mail !"); //Internal error
		
		//Else we can say that a mail was sent
		return array("success" => "A mail was sent !");
	}
}