/**
 * Project common utilies
 * 
 * @author Pierre HUBERT
 */

/**
 * Get an element specified by its ID (mirror or document.getElementById)
 * 
 * @param {String} id The ID of the object to get
 * @return {HTMLobject}
 */
function byId(id){
    return document.getElementById(id);
}

/**
 * Create a new HTML element with a type specified as argument
 * 
 * @param {String} elemName The name of the new element
 * @return {HTMLobject}
 */
function newElem(elemName){
    return document.createElement(elemName);
}