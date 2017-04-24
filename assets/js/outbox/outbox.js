/**
 * Outbox javascript side
 * Main file
 * 
 * @author Pierre HUBERT
 */

/**
 * Outbox object
 */
AMSS.outbox = {

    /**
     * Messages target
     */
    messagesTarget: "messagesTarget",

    /**
     * Refresh table content
     * 
     * @return {Boolean} True for a success
     */
    reloadContent: function(){

        //Prepare the API request
        var apiURI = "messages/getList";
        var params = {};
        
        //Prepare what to do next
        var onceGotList = function(result){
            //We check if there was an error
            if(result.error){

                //Display the error
                AMSS.common.informations.display(
                    AMSS.outbox.messagesTarget, 
                    "error", 
                    "Messages list couldn't be retrieved ! <br /> Error code: "+result.error.code+" <br /> Message: <i>"+result.error.message+"</i>"
                );

                //We return that there was an error
                return false;

            }
            else{
                //We can write the list
                //Get contener element
                var outboxContenerElem = byId("outboxContentTarget");

                //Empty container
                outboxContenerElem.innerHTML = "";

                //Process each line
                for(i in result.messagesList){

                    //Create a new line
                    var lineElem = document.createElement("tr");

                    //Extract some important informations
                    var mailID = result.messagesList[i].id;
                    var mailPlanned = result.messagesList[i].planned === "1";

                    //Add number
                    var numberCellElem = newElem("td");
                    numberCellElem.innerHTML = result.messagesList[i].num;
                    lineElem.appendChild(numberCellElem);

                    //Add mailID
                    var IDcellElem = newElem("td");
                    IDcellElem.innerHTML = mailID;
                    lineElem.appendChild(IDcellElem);

                    //Add expeditor name
                    var expeditorCellElem = newElem("td");
                    expeditorCellElem.innerHTML = result.messagesList[i].from_name + " &lt;" + result.messagesList[i].from_mail + "&gt;";
                    lineElem.appendChild(expeditorCellElem);

                    //Add destination name
                    var destinationCellElem = newElem("td");
                    destinationCellElem.innerHTML = result.messagesList[i].destination_mail;
                    lineElem.appendChild(destinationCellElem);

                    //Add Subject
                    var subjectCellElem = newElem("td");
                    subjectCellElem.innerHTML = result.messagesList[i].subject;
                    lineElem.appendChild(subjectCellElem);

                    //Add send date
                    var sendDateCellElem = newElem("td");
                    sendDateCellElem.innerHTML = result.messagesList[i].send_date + " " + result.messagesList[i].send_time;
                    lineElem.appendChild(sendDateCellElem);

                    //Add plan state cell
                    var plannedCellElem = newElem("td");
                        var planButton = newElem("button");

                        //We check if the mail is already planned or not
                        if(mailPlanned){
                            planButton.setAttribute("class", "btn btn-xs bg-purple");
                            planButton.innerHTML = "Planned";
                        }
                        else {
                            planButton.setAttribute("class", "btn btn-xs");
                            planButton.innerHTML = "Not planned";
                        }
                        
                        //Make the plan button dynamic
                        planButton.setAttribute("data-mailID", mailID);
                        planButton.setAttribute("id", mailID+"_planButton");
                        planButton.onclick = function(){
                            AMSS.outbox.revertPlanState(this.getAttribute("data-mailID"));
                        }

                        plannedCellElem.appendChild(planButton);
                    lineElem.appendChild(plannedCellElem);

                    //Add action cell
                    var actionCellElem = newElem("td");

                        //Button group
                        var actionButtonGroupElem = newElem("span");
                        actionButtonGroupElem.className = "btn-group";
                        actionCellElem.appendChild(actionButtonGroupElem);

                            //View button
                            var viewButton = newElem("button");
                            viewButton.className = "btn btn-default btn-xs";
                            viewButton.innerHTML = '<i class="fa fa-search"></i>';
                            viewButton.setAttribute("data-mailID", mailID);
                            viewButton.onclick = (function(){
                                AMSS.common.mails.display(this.getAttribute("data-mailID"));
                            });
                            actionButtonGroupElem.appendChild(viewButton);
                            
                            //Edit button
                            var editButton = newElem("button");
                            editButton.className = "btn btn-default btn-xs";
                            editButton.innerHTML = '<i class="fa fa-pencil"></i>';
                            editButton.setAttribute("data-editURL", AMSS.__config.siteURL + "compose?mailID=" + mailID);
                            editButton.onclick = (function(){
                                location.href = this.getAttribute("data-editURL");;
                            });
                            actionButtonGroupElem.appendChild(editButton);

                            //Delete button
                            var deleteButton = newElem("button");
                            deleteButton.className = "btn btn-default btn-xs";
                            deleteButton.innerHTML = '<i class="fa fa-trash"></i>';
                            deleteButton.setAttribute("data-mailID", mailID);
                            deleteButton.onclick = (function(){
                                AMSS.outbox.deleteMail(this.getAttribute("data-mailID"));
                            });
                            actionButtonGroupElem.appendChild(deleteButton);

                    lineElem.appendChild(actionCellElem);

                    //Apply new line
                    outboxContenerElem.appendChild(lineElem);
                }
            }

        };

        //Perform API request
        AMSS.common.api.makeAPIrequest(apiURI, params, onceGotList);

        //Everything went good if the script is here
        return true;
    },

    /**
     * Revert the currrent plan state of a mail
     * 
     * @param {String} mailID The ID of the mail to change
     * @return {Boolean} True for a success
     */
    revertPlanState: function(mailID){
        //First, get the plan button
        var planButton = byId(mailID+"_planButton");

        //Now check if the button is planned or not
        if(planButton.innerHTML == "Planned"){
            //Because the mail was planned, we will "unplan" it
            newPlanState = false;
        }
        else if(planButton.innerHTML == "Not planned"){
            //Because the mail wasn't planned, we will plan it
            newPlanState = true;
        }
        else{
            //An other operation is already pending for this button
            return false;
        }

        //We make the plan button neutral
        planButton.innerHTML = "Loading";

        //Now we can make an API request
        var apiURI = "messages/plan";
        var params = {
            mailID: mailID,
            plan: newPlanState,
        }

        //We prepare the next steps
        var afterChangePlanState = function(result){

            //We first check if there was an error
            if(result.error){
                //Display the error
                AMSS.common.informations.display(
                    AMSS.outbox.messagesTarget, 
                    "error", 
                    "Plan state couldn't be changed ! <br /> Error code: "+result.error.code+" <br /> Message: <i>"+result.error.message+"</i>"
                );

                //We display an error icon at plan state
                planButton.innerHTML = "<i class='fa fa-warning'> Error</i>";
                planButton.className = "btn btn-xs btn-danger";

                //We return that there was an error
                return false;
            }
            else {
                //Else it is a success
                //We can change the button to its new state
                if(newPlanState){
                    //The mail is now planned
                    planButton.setAttribute("class", "btn btn-xs bg-purple");
                    planButton.innerHTML = "Planned";
                }
                else {
                    //The mail has now to be planned
                    planButton.setAttribute("class", "btn btn-xs");
                    planButton.innerHTML = "Not planned";
                }
            }
        };

        //We can now perform an API request
        AMSS.common.api.makeAPIrequest(apiURI, params, afterChangePlanState);

        //If the script go there, everything went good
        return true;

    },

    /**
     * Delete a mail
     * 
     * @param {String} mailID The ID of the mail to delete
     * @return {Boolean} True for a success
     */
    deleteMail: function(mailID){
        //First, we need a confirmation from user
        //We prepare what will happen next
        var afterConfirm = function(result){

            //We check if user said no
            if(!result)
                return false; //Nothing to be done

            //Prepare the API request
            var apiURI = "messages/delete";
            var params = {
                mailID: mailID,
                confirm: true,
            }

            //Prepare what to do after the request
            var afterDelete = function(result){
                //We first check if there was an error
                if(result.error){
                    //Display the error
                    AMSS.common.informations.display(
                        AMSS.outbox.messagesTarget, 
                        "error", 
                        "The mail couldn't be deleted ! <br /> Error code: "+result.error.code+" <br /> Message: <i>"+result.error.message+"</i>"
                    );

                    //We return that there was an error
                    return false;
                }
                else {
                    //Else it is a success
                    //We show a success message
                    AMSS.common.informations.display(
                        AMSS.outbox.messagesTarget, 
                        "success", 
                        "The mail was successfully deleted !"
                    );

                    //Refresh the messages list
                    AMSS.outbox.reloadContent();
                }
            }

            //Perform the request
            AMSS.common.api.makeAPIrequest(apiURI, params, afterDelete);
        }

        //Prepare modal content
        confirmModalContent = newElem("p");
        confirmModalContent.innerHTML = "Are you sure do you want to delete this mail ? This operation can't be reverted !";

        //Show the confirm dialog
        AMSS.common.informations.displayModal("danger", 
            "Confirm", 
            confirmModalContent, 
            "Cancel", 
            afterConfirm, 
            "Delete"
        );

        //The function was executed correctly
        return true;
    },

};

/**
 * End of page scripts executions
 */
//Load outbox content
AMSS.outbox.reloadContent();