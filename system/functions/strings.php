<?php
/**
 * Strings functions
 *
 * @author Pierre HUBERT
 */

/**
 * Convert data from a date and a time picker to a timestamp
 *
 * @param String $date_picker Data from the date picker
 * @param string $time_picker Data from the time picker
 * @return Integer The timestamp as an integer
 */
function pickersToTimestamp($date_picker, $time_picker){
    
    //Decompose time & date
    $array_date = explode("/", $date_picker);
    //$array_time = explode(":", $time_picker);

    //Create right date string
    $date_string = $array_date[2]."-".$array_date[1]."-".$array_date[0]." ".$time_picker.":00";

    $date = new DateTime($date_string, new DateTimeZone('Europe/Paris'));
    $timestamp = $date->getTimestamp();

    //Return timestamp
    return $timestamp;
}