<?php
/**
 * Statistics main controller
 *
 * @author Pierre HUBERT
 */
class StatisticsController {
    /**
     * Get all the statisics
     *
     * @url POST api.php/stats/get
     */
    public function getAllStatistics(){
        
        //Prepare return
        $return = array();
        
        //Get the number of mails in the datbabase
        if(($return['numberOfMails'] = AMSS::getInstance()->stats->numberOfMails()) === false)
            Rest_fatal_Error("500", "Couldn't get the total number of mails !"); //Internal error

        //Get the number of planned mails in the datbabase
        if(($return['plannedMails'] = AMSS::getInstance()->stats->plannedMails()) === false)
            Rest_fatal_Error("500", "Couldn't get the number of planned mails !"); //Internal error
        

        //Get the number of mail ready to be sent in database
        if(($return['mailsReady'] = AMSS::getInstance()->stats->mailsReady()) === false)
            Rest_fatal_Error("500", "Couldn't get the number of mails ready to be sent !"); //Internal error

        //Else we can return result
        return $return;
    }
}