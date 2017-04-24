<?php
/**
 * Mails main method
 *
 * @author Pierre HUBERT
 */

class mails {

	/**
	 * @var String $mailTableName The table which contains the mails
	 */
	 private $mailTableName = DB_PREFIX."mails";

	/**
	 * Public constructor
	 */
	public function __construct(){
		//Nothing now
	}

	/**
	 * Check if a mail exists or not
	 *
	 * @param String $id The ID of the mail to check
	 * @return Boolean True if the mail exists
	 */
	public function checkMailExistence($id){
		//Perform a request in the database
		return $this->parent->db->count($this->mailTableName, "WHERE id = ?", array($id)) != 0;
	}

	/**
	 * Save mail changes (update || insert)
	 *
	 * @param String $id The id of the mail
	 * @param String $from_name The name of the sender
	 * @param String $from_mail E-mail address of sender
	 * @param String $destination_mail E-mail address of the destination
	 * @param String $subject The subject of the mail
	 * @param String $message The message of the mail
	 * @param String $send_date The date on what the mail will be sent
	 * @param String $send_time The time from which the mail will be sent
	 * @return Boolean Depends of the success of the operation
	 */
	public function saveMailChanges($id, $from_name, $from_mail, $destination_mail, $subject, $message, $send_date, $send_time){

		//Generate the timestamp of the message
		$send_timestamp = pickersToTimestamp($send_date, $send_time);

		//New data to commit on database
		$mailValues = array(
			"from_name" => $from_name,
			"from_mail" => $from_mail,
			"destination_mail" => $destination_mail,
			"subject" => $subject,
			"message" => $message,
			"send_date" => $send_date,
			"send_time" => $send_time,
			"send_timestamp" => $send_timestamp
		);

		//Check if mail exists or not
		if(!$this->checkMailExistence($id)){
			//Add mail ID to the values
			$mailValues["id"] = $id;
			$mailValues["creation_date"] = date('l jS \of F Y h:i:s A');;

			//Try to insert the mail
			if(!$this->parent->db->addLine(DB_PREFIX."mails", $mailValues)){
				//Something went wrong
				return false;
			}
		}
		else {
			//Update the mail
			$conditions = "id = ?";
			$whereValues = array($id);
			if(!$this->parent->db->updateDB($this->mailTableName, $conditions, $mailValues, $whereValues))
				return false; //Something went wrong
		}

		//If we arrive here, everything may be OK...
		return true;
	}

	/**
	 * Retrieve informations about a mail
	 *
	 * @param String $id The ID of the mail
	 * @return Mixed False if it fails, an array with data for a success
	 */
	public function getInformations($id){
		//First, check if the mail exists or not
		if(!$this->checkMailExistence($id))
			return false; //With no mail, we can't continue
		
		//Make a request on the database
		if(!$data = $this->parent->db->select($this->mailTableName, "WHERE id = ?", array($id))){
			return false; //An error occured
		}

		//Else we return the first result
		return $data[0];
	}

	/**
	 * Plan a mail
	 *
	 * @param String $mailID The ID of the mail to plan
	 * @param Boolan $planState True: plan the mail / False: do not send the mail
	 * @return Boolean Depends of the success of the operation
	 */
	public function plan($mailID, $planState){

		//Prepare changes to perform on the database
		$changes = array(
			"planned" => ($planState ? 1 : 0),
		);
		$conditions = "id = ?";
		$whereValues = array($mailID);

		//Try to perform request on the database
		if(!$this->parent->db->updateDB($this->mailTableName, $conditions, $changes, $whereValues))
			return true;

		//The mail was successfully planned
		return true;
	}

	/**
	 * Retrieve messages list
	 *
	 * @param Boolean $withMessageContent Specify if the content of the messages
	 * may be included in the response.
	 * @return Mixed False for a failure / Array for a success
	 */
	public function getList($withMessageContent=false){
		//Perform a request on the database
		if(!$mailsList = $this->parent->db->select($this->mailTableName))
			//Something went wrong
			return false;
		
		//Process the list
		$return = array();
		foreach($mailsList as $i=>$value){
			$return[$i] = array(
				"num"=>$value['num'],
				"id"=>$value['id'],
				"creation_date"=>$value['creation_date'],
				"from_name"=>$value['from_name'],
				"from_mail"=>$value['from_mail'],
				"destination_mail"=>$value['destination_mail'],
				"subject"=>$value['subject'],
				"send_date"=>$value['send_date'],
				"send_time"=>$value['send_time'],
				"planned"=>$value['planned'],
				"send_timestamp"=>$value['send_timestamp'],
			);

			//If required, include message content
			if($withMessageContent){
				$return[$i]["message"] = $value["message"];
			}
		}

		//Return result
		return $return;
	}

	/**
	 * Delete a mail
	 *
	 * @param String $mailID The ID of the mail to delete
	 * @return Boolean True for a success
	 */
	public function delete($mailID){

		//Perform the request on the database
		$condition = "id = ?";
		$values = array($mailID);
		if(!$this->parent->db->deleteEntry($this->mailTableName, $condition, $values))
			return false; //An error occurred

		//If we went there, the result is positive
		return true;
	}

	/**
	 * Check if there is a mail ready to be sent
	 *
	 * @return Boolean True or false
	 */
	public function isThereMailToSend(){
		return $this->parent->db->count($this->mailTableName, 
			"WHERE send_timestamp <= ? AND planned = 1", //Define minimal timestamp
			array(time()) //Give the current time
		) != 0;
	}

	/**
	 * Send a mail and then remove it from the outbox
	 *
	 * @return Boolean True for a success
	 */
	public function sendAmail(){
		//First, we check if there is really a mail to send
		if(!$this->isThereMailToSend())
			return false; //There isn't any mail to be sent now
		
		//We get the oldest mail to send
		//We perform a request on the database
		$conditions = "WHERE send_timestamp <= ? AND planned = 1 ORDER BY send_timestamp LIMIT 1";
		$values = array(time());
		if(!$infosMessage = $this->parent->db->select($this->mailTableName, $conditions, $values))
			return false; //An error occured while retrieving the mail

		//We check we have only one entry
		if(count($infosMessage) != 1)
			return false; //Something "strange" has just happened > error
		
		//We can now send the message
		$infosMessage = $infosMessage[0];
		$from = $infosMessage["from_name"]." <".$infosMessage["from_mail"].">";
		$to = $infosMessage["destination_mail"];
		$subject = $infosMessage["subject"];
		$message = wordwrap($infosMessage["message"], 70, "\r\n");
		
		//Prepare headers
		// To send HTML mail, the Content-type header must be set
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		// Additional headers
		$headers[] = 'From: '.$from;

		//Send the mail
		if(!mail($to, $subject, $message,  implode("\r\n", $headers)))
			return false; //This is an error

		//Delete the mail
		if(!$this->delete($infosMessage["id"]))
			return false; //Couldn't delete the mail

		//Check if we have to send an hidden copy
		if($this->parent->config->get("emailAddressCC")){

			//Sleep 3 seconds to avoid ban
			sleep(3);

			//Add an hidden destination
			//Change subject
			$subject = "COPY - ".$subject;

			//Change the message
			$message .= "\n <p>You received this message because you are registered in the\n";
			$message .= "AMSS system to receive a copy of all the mail that are sent through it.</p>\n";
			$message .= "<p>The destination of this mail was <i>".$to."</i></p>\n";

			//Change destination mail
			$to = $this->parent->config->get("emailAddressCC");

			//Send the mail again
			mail($to, $subject, $message, implode("\r\n", $headers));
		}

		//If we arrive there, then the mail was successfully send
		return true;
	}
}