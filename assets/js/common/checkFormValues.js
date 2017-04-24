/* 
 * The MIT License
 *
 * Copyright 2016 pierre.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Form values check
 * 
 * @author Pierre HUBERT
 */

/**
 * Check an input
 * 
 * @param {String} fieldID The ID of the field to check
 * @return {Boolean} True or false depending of the validity of the field
 */
function checkInput(fieldID){
    //First, we try to get input
    var inputElem = document.getElementById(fieldID);
    
    //Check if the field exists
    if(!inputElem){
        console.log("Specified field doesn't exists !");
        return false;
    }
    
    //Get field type
    var fieldType = inputElem.type;
    
    //Retrieve field value
    if(inputElem.value){
        //Get field value
        var fieldValue = inputElem.value;
    }
    else {
        //For textareas
        var fieldValue = inputElem.innerHTML;
    }
    
    //Check if field value is empty
    if(fieldValue == "" || fieldValue == " "){
        //Set the input and text color to red
        changeFieldColor(fieldID, "red");
        return false;
    }
    
    //Check email address if required
    if(fieldType == "email"){
        if(!checkEmail(fieldValue)){
            changeFieldColor(fieldID, "red");
            return false;
        }
    }
    
    //Everything is OK
    changeFieldColor(fieldID, "black");
    return true;
}

/**
 * Change the text and border color of an input
 * 
 * @param {String} fieldID The ID of the field to change color
 * @param {String} color The color to choose
 */
function changeFieldColor(fieldID, color){
    var elem = document.getElementById(fieldID);
    elem.style.color = color;
    elem.style.border = "1px " + color + "solid";
}

/**
 * Check an email
 * 
 * @param {String} email The email to check
 * @return {Boolean} True or false depending of the success of the operation
 */
function checkEmail(email){
    if(email.match(/^[a-zA-Z0-9_.]+@[a-zA-Z0-9-]{1,}[.][a-zA-Z]{2,5}$/))
        return true; //Email is OK
    else
        return false; //There is an error in email address
}