/**
 * Mails common functions
 * 
 * @author Pierre HUBERT
 */

/**
 * Mail common functions object
 */
AMSS.common.mails = {
    /**
     * Display a mail informations (complete)
     * 
     * @param {String} mailID The 
     * @return {Boolan} True for a success
     */
    display: function(mailID){
        //Make an API request
        var apiURI = "messages/getInfos"
        var params = {
            mailID: mailID
        };

        //What to do once we got informations
        var onceGotMail = function(response){
            //We check if there is an error
            if(response.error){
                //Create and display an error modal
                var type = "danger";
                var title = "Error";
                
                //Modal content
                var modalContent = newElem("p");
                modalContent.innerHTML = "The message couldn't be retrieved! The server returned : <br />"
                modalContent.innerHTML += "Error code: " + response.error.code + "<br />";
                modalContent.innerHTML += "Error message: <i>" + response.error.message + "<i><br />";

                //Display the modal
                AMSS.common.informations.displayModal(type, title, modalContent);

                //There was an error
                return false;
            }

            //Now we can display informations about the mail in a modal
            //Create and display a modal
            var type = "default";
            var title = "Mail informations";
            
            //Modal content
            var modalContent = newElem("div");

            //Display metadata
            var metadataTable = newElem("table");
            metadataTable.className = "table table-condensed table-hover";
            modalContent.appendChild(metadataTable);

            //Metadata body
            var metadataTbody = newElem("tbody");
            metadataTable.appendChild(metadataTbody);

                //Number
                //var numberCell = newElem("tr");
                //numberCell.innerHTML = "<td>Mail number</td><td>" + response.mailInformations.num + "</td>";
                //metadataTbody.appendChild(numberCell);

                //MailID
                var idCell = newElem("tr");
                idCell.innerHTML = "<td>ID</td><td>" + response.mailInformations.id + " (Mail number " + response.mailInformations.num + ")</td>";
                metadataTbody.appendChild(idCell);

                //Creation date
                var creationDateCell = newElem("tr");
                creationDateCell.innerHTML = "<td>Creation date</td><td>" + response.mailInformations.creation_date + "</td>";
                metadataTbody.appendChild(creationDateCell);

                //Sending date
                var plannedMessage = (response.mailInformations.planned == "0" ? "Not planned" : "Planned")
                var sendCell = newElem("tr");
                sendCell.innerHTML = "<td>Sending date</td><td>" + response.mailInformations.send_date + " " + response.mailInformations.send_time + " (<b>"+plannedMessage+"</b>) </td>";
                metadataTbody.appendChild(sendCell);
                
                //Expeditor
                var expeditorCell = newElem("tr");
                expeditorCell.innerHTML = "<td>From</td><td>" + response.mailInformations.from_name + " &lt;" + response.mailInformations.from_mail + "&gt;</td>";
                metadataTbody.appendChild(expeditorCell);

                //Destination
                var destinationCell = newElem("tr");
                destinationCell.innerHTML = "<td>To</td><td>" + response.mailInformations.destination_mail + "</td>";
                metadataTbody.appendChild(destinationCell);

                //Subject
                var destinationCell = newElem("tr");
                destinationCell.innerHTML = "<td>Subject</td><td>" + response.mailInformations.subject + "</td>";
                metadataTbody.appendChild(destinationCell);

                //Message
                var messageCell = newElem("tr");
                messageCell.innerHTML = "<td>Message</td><td>" + response.mailInformations.message + "</td>";
                metadataTbody.appendChild(messageCell);

            //Display the modal
            AMSS.common.informations.displayModal(type, title, modalContent);

            //Everything went good
            return true;
        }

        //Perform API request
        AMSS.common.api.makeAPIrequest(apiURI, params, onceGotMail);

        //Everything seems to be OK
        return true;
    }

};