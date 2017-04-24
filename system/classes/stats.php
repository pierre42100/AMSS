<?php
/**
 * Statistics main method
 *
 * @author Pierre HUBERT
 */
class Statistics {

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
	 * Get the number of mail in outbox
	 *
	 * @return Mixed False for a failure / The number of mails in outbox in case of success
	 */
	 public function numberOfMails(){
		 //Perform a request on the database
		 if(!$number = $this->parent->db->count($this->mailTableName))
			return false;
		
		//Else everything is OK, we can return the result
		return $number;
	 }

	/**
	 * Get the number of planned mail in outbox
	 *
	 * @return Mixed False for a failure / The number of planned mails in outbox for a success
	 */
	 public function plannedMails(){
		//Perform a request on the database
		return $this->parent->db->count($this->mailTableName, "WHERE planned = 1");
	 }

	/**
	 * Get the number of mail ready to be sent
	 *
	 * @return Mixed False for a failure / The number of mails ready to be sent for a succes
	 */
	public function mailsReady(){
		//Perform a request on the database
		return $this->parent->db->count($this->mailTableName, 
			"WHERE send_timestamp <= ? AND planned = 1", //Define minimal timestamp
			array(time()) //Give the current time
		);
	}

}