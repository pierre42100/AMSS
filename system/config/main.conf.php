<?php
/**
 * Main configuration file for the project
 *
 * @author Pierre HUBERT
 */

/**
 * Site URL for the project
 * Must include the last slash
 */
$config->set("site_url", "http://devweb.local/AMSS/");

/**
 * Name of the website
 */
$config->set("site_name", "AMSS");

/**
 * Site mode (debug or production)
 */
$config->set("site_mode", "debug");

/**
 * Log folder name
 * The log folder must be present in the appliccation data folder (security reason)
 */
$config->set("logFolder", "logs/");

/**
 * Defines the number of days logs may be kept
 */
$config->set("keepLogs", 14); //14 days

/**
 * Database name (name of sqlite file)
 * The database must be in data folder (security reasons)
 */
$config->set("database_file", "database.sqlite");

/**
 * Database prefix
 */
$config->set("database_prefix", "db_");

/**
 * Username and password to enter the system
 */
$config->set("user_credentials", array(
    "user_name" => "admin admin",
    "password" => "", //Use crypt(sha1("Password"), sha1("Password")); To generate a password
   "user_mail" => "someone@example.com" 
));
