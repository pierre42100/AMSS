/**
 * Home functions
 * 
 * @author Pierre HUBERT
 */

AMSS.home = {
    /**
     * Load home statistics
     * 
     * @return Boolean True for a success
     */
    loadHomeStatistics: function(){
        
        //Make an API request
        var apiURI = "stats/get";
        var params = {};

        //Prepare what to do next
        var onceReady = function(response){
            //We check if there is an error
            if(response.error){
                //Create and display an error modal
                var type = "danger";
                var title = "Error";
                
                //Modal content
                var modalContent = newElem("p");
                modalContent.innerHTML = "Couldn't get statistics! The server responded : <br />"
                modalContent.innerHTML += "Error code: " + response.error.code + "<br />";
                modalContent.innerHTML += "Error message: <i>" + response.error.message + "<i><br />";

                //Display the modal
                AMSS.common.informations.displayModal(type, title, modalContent);

                //There was an error
                return false;
            }

            //We can continue and apply the values
            byId("messagesInOutbox").innerHTML = response.numberOfMails;
            byId("notPlannedMessages").innerHTML = response.numberOfMails - response.plannedMails;
            byId("plannedMessages").innerHTML = response.plannedMails;
            byId("messagesInQueue").innerHTML = response.mailsReady;
        }

        //Perform API request
        AMSS.common.api.makeAPIrequest(apiURI, params, onceReady);

        //Everything went good
        return true;
    }
};

//Load statistics
AMSS.home.loadHomeStatistics();