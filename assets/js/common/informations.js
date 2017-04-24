/**
 * Informations file
 * 
 * @author Pierre HUBERT
 */

AMSS.common.informations = {
    /**
	 * Display message info (on specified message box)
	 * 
	 * @param {String} target The target of the message
     * @param {String} type The type of message (error/warning/info/success)
	 * @param {String} content The content of the message
	 * @param {String} title The title of the message
	 * @return {Boolean} True for a success
	 */
	display: function(target, type, content, title){
		//Determine callout type
		if(type=="error")
			calloutType="danger";
		else
			calloutType = type;

		//Create callout element
		var calloutElem = document.createElement("div");
		calloutElem.setAttribute("class", "callout callout-"+calloutType);

		//Add a title if specified
		if(title){
			var titleElem = document.createElement("h4");
			titleElem.innerHTML = title;
			calloutElem.appendChild(titleElem);
		}

		//Add the message to the callout
		var messageElem = document.createElement("p");
		messageElem.innerHTML = content;
		calloutElem.appendChild(messageElem);

		//Applay the callout element
		var messageContener = byId(target);
		messageContener.innerHTML = "";
		messageContener.appendChild(calloutElem);

		//Everyting went good
		return true;
	},

    /**
     * Remove any remaining message info
     * 
     * @param {String} target The target of the message
     * @return {Boolean} True for a success
     */
    remove: function(target){
        //Remove the message on the target
        byId(target).innerHTML = "";

        //Everything went good
        return true;
    },

	/**
	 * Display a window modal (large modal)
	 * 
	 * @param {String} type The type of the modal (default, danger, success, warning, info, primary)
	 * @param {String} title The title of the modal
	 * @param {HTMLelement} content The content of the modal, as an HTML object 
	 * @param {String} closeButtonName Optionnal, the name of the close button
	 * @param {Function} afterModal Optionnal, define what to do once the modal is confirmed
	 * @param {String} confirmButtonName Optionnal, define the name of the confirm button
	 * @return {Boolean} True for a success
	 */
	displayModal: function(type, title, content, closeButtonName, afterModal, confirmButtonName){
		//Create the modal
		var modal = newElem("div");
		if(type == "default"){
			//Define modal type
			modal.className = "modal"

			//Define generic bottom buttons class
			var bottomButtonClass = "btn btn-primary";
		}
		else{
			//Define modal type
			modal.className = "modal modal-"+type;

			//Define generic bottom buttons class
			var bottomButtonClass = "btn btn-outline";
		}
			
		document.body.appendChild(modal);

		//Create modal dialog
		var modalDialog = newElem("div");
		modalDialog.className = "modal-dialog";
		modal.appendChild(modalDialog);

		//Create modal content
		var modalContent = newElem("div");
		modalContent.className = "modal-content";
		modalDialog.appendChild(modalContent);

		//Create modal header
		var modalHeader = newElem("div");
		modalHeader.className = "modal-header";
		modalContent.appendChild(modalHeader);

			//Close button
			var modalCloseButton = newElem("button");
			modalCloseButton.className = "close";
			modalCloseButton.type = "button";
			modalCloseButton.setAttribute("data-dismiss", "modal");
			modalCloseButton.setAttribute("aria-lable", "Close");
			modalCloseButton.innerHTML = '<span aria-hidden="true">×</span>';
			modalCloseButton.onclick = function(){
				this.parentNode.parentNode.parentNode.parentNode.remove();
			}
			modalHeader.appendChild(modalCloseButton);
		
			//Modal title
			var modalTitle = newElem("h4");
			modalTitle.className = "modal-title";
			modalTitle.innerHTML = title;
			modalHeader.appendChild(modalTitle);
		

		//Modal body
		var modalBody = newElem("div");
		modalBody.className = "modal-body";
		modalContent.appendChild(modalBody);

			//Apply modal body content
			modalBody.appendChild(content);

		//Modal footer
		var modalFooter = newElem("div");
		modalFooter.className = "modal-footer";
		modalContent.appendChild(modalFooter);

			//Cancel button
			var cancelButton = newElem("button");
			cancelButton.type = "button";
			modalFooter.appendChild(cancelButton);

			//Cancel button next action
			cancelButton.onclick = function(){
				//Close modal
				this.parentNode.parentNode.parentNode.parentNode.remove();

				//Perform next action (if any)
				if(afterModal)
					afterModal(false);
			}

			//Cancel button title
			if(!closeButtonName)
				cancelButton.innerHTML = "Close";
			else
				cancelButton.innerHTML = closeButtonName;
			
			//Cancel button class name (depends of the presence of a next action)
			if(afterModal){
				cancelButton.className = bottomButtonClass + " pull-left";
			}
			else {
				cancelButton.className = bottomButtonClass;
			}

			//Confirm button (if required)
			if(afterModal){

				//Confirm button
				var confirmButton = newElem("button");
				confirmButton.className = bottomButtonClass;
				confirmButton.type = "button";
				modalFooter.appendChild(confirmButton);

				//Confirm button next action
				confirmButton.onclick = function(){
					
					//Close modal
					this.parentNode.parentNode.parentNode.parentNode.remove();

					//Do next action (true);
					afterModal(true);

				};

				//Confirm button name
				if(confirmButtonName)
					confirmButton.innerHTML = confirmButtonName;
				else
					confirmButton.innerHTML = "Confirm";
			}

		//Display the modal
		modal.style.display = "block";

		//If we are here, it is a success
		return true;
	},
};