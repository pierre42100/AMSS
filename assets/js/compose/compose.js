/**
 * Compose javascript functions
 * 
 * @author Pierre HUBERT
 */

/**
 * Compose a message page (main object)
 */
AMSS.compose ={
	/**
	 * @var String composeMessageTarget The ID of the target for compose messages
	 */
	messageTarget: "composeMessageTarget",

	/**
	 * Check if the composed message is valid or not
	 * 
	 * @return {Boolean} True or false depending of the validity of the message
	 */
	checkComposedMessage: function(){
		//Check all the fields
		//Prepare invalid fiels summary
		var invalidFields = [];

		//Check sender mail address
		if(!checkInput("from_mail")){
			invalidFields.push("Expeditor mail");
		}
		else {
			//Get mail value 
			var expeditorMail = byId("from_mail").value;
			if(expeditorMail.indexOf("@"+AMSS.__config.sendDomain) === -1){
				invalidFields.push("Expeditor mail domain.");
			}
		}

		//Check sender name
		if(!checkInput("from_name")){
			invalidFields.push("Expeditor name");
		}

		//Check destination mail
		if(!checkInput("destination")){
			invalidFields.push("Destination mail");
		}

		//Check subject
		if(!checkInput("subject")){
			invalidFields.push("Subject");
		}

		//Check datepicker
		if(!checkInput("datepicker")){
			invalidFields.push("Datepicker");
		}
		
		//Check timepicker
		if(!checkInput("timepicker")){
			invalidFields.push("Timepicker");
		}

		//Check if any error was found
		if(invalidFields.length != 0){

			//Display an error on the screen
			message = "Please check the following fields : <br><ol>";
			for(i in invalidFields){
				message += "<li>"+invalidFields[i]+"</li>";
			}
			message += "</ol>";
			AMSS.common.informations.display(this.messageTarget, "error", message);

			//Something was incorrect
			return false;
		}

		//Remove any remaining error message
		AMSS.common.informations.remove(this.messageTarget);

		//If the script read this line, the message should be OK
		return true;
	},

	/**
	 * Save the current state of the message
	 * 
	 * @param {Function} afterSaving Optionnal, define what to do once the mail was saved (on success)
	 * @return {Boolean} True for a success
	 */
	saveComposedMessage: function(afterSaving){
		//Check if the fields are valid or not
		if(!this.checkComposedMessage()){
			return false;
		}

		//Get all the fields
		var message = {
			message_id: byId("mailID").value,
			from_name: byId("from_name").value,
			from_mail: byId("from_mail").value,
			destination_mail: byId("destination").value,
			subject: byId("subject").value,
			datepicker: byId("datepicker").value,
			timepicker: byId("timepicker").value,
			message: this.getWysihtml5SourceCode()
		};

		//Make an API request
		apiURI = "messages/save";
		params = message;
		
		//What to do next
		var afterSave = function(result){

			//We check if there is an error
			if(result.error){
				//Display an error message
				AMSS.common.informations.display(AMSS.compose.messageTarget, "error", "The message couldn't be saved ! <br /> Error code: "+result.error.code+" <br /> Message: <i>"+result.error.message+"</i>");
			}
			//Else everything went good
			else {
				//Display a success message
				AMSS.common.informations.display(AMSS.compose.messageTarget, "success", "The message was successfully saved !");

				//We perform the next action (if any)
				if(afterSaving){
					afterSaving();
				}
			}
		}

		//Perform the request
		AMSS.common.api.makeAPIrequest(apiURI, params, afterSave);

		//Everything went good
		return true;
	},

	/**
	 * Mark the mail as planned, after what it will be automaticaly sent
	 * 
	 * @return {Boolean} True for a success
	 */
	planMail: function(){
		
		//What to do once the mail was successfully saved
		var afterSaving = function(){
			
			//We perform an API request to inform the server to send the mail
			apiURI = "messages/plan";
			params = {
				"mailID": byId("mailID").value,
				"plan": true,
			}

			//What to do once the mail was planned
			var afterPlan = function(result){

				//We check if there is an error
				if(result.error){
					//Display an error message
					AMSS.common.informations.display(AMSS.compose.messageTarget, "error", "The message couldn't be planned ! <br /> Error code: "+result.error.code+" <br /> Message: <i>"+result.error.message+"</i>");
				}
				//Else everything went good
				else {
					//Display a success message
					AMSS.common.informations.display(AMSS.compose.messageTarget, "success", "The message was successfully planned ! It will be automaticaly sent on the time specified in the form.");
				}
			}

			//Perform the request
			AMSS.common.api.makeAPIrequest(apiURI, params, afterPlan);
		}

		//Now save the mail
		this.saveComposedMessage(afterSaving);

		//Everything went good
		return true;
	},

	/**
	 * Save a mail and then go back to the outbox
	 */
	saveAndExit: function(){
		//What to do once the mail was successfully saved
		var afterSaving = function(){
			//Redirect to the outbox page (only on success)
			location.href= AMSS.__config.siteURL + "outbox";
		}

		//Now save the mail
		this.saveComposedMessage(afterSaving);

		//Everything went good
		return true;
	},

	/**
	 * Display a message to inform user about the validity of the message
	 */
	notify_checkComposedMessage: function(){
		if(this.checkComposedMessage()){
			alert("The composed message seems to be valid !");
		}
		else{
			alert("Please check your message (didn't pass test) !");
		}
	},

	/**
	 * Get and return the source code of the first wysihtml5
	 * editor opened
	 * 
	 * @return {String} The source code of the editor
	 */
	getWysihtml5SourceCode: function(){
		return document.getElementsByClassName("wysihtml5-sandbox")[0].contentWindow.document.body.innerHTML;
	}
};

/**
 * End of page initialization scripts
 */
$(function () {

	//Add text editor
	$("#compose-textarea").wysihtml5();

	//Date picker
	$('#datepicker').datepicker({
		autoclose: true,
		format: 'dd/mm/yyyy'
	});

	//Timepicker
	$(".timepicker").timepicker({
		showInputs: false,
		showMeridian: false,
	});
});

/**
 * Make expeditor editable thanks to an easter egg.
 */
byId('label_from').ondblclick = function(){
	if(byId("from_name").disabled === true){
		byId("from_name").disabled = false;
		byId("from_mail").disabled = false;
	}
	else {
		byId("from_name").disabled = true;
		byId("from_mail").disabled = true;
	}
}