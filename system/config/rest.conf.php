<?php
/**
 * RestServer specific configuration
 *
 * @author Pierre HUBERT
 */

/**
 * Security tokens
 * These are needed for logouted users
 */
$config->set("securityTokens", array(
    "token1"=>sha1(rand(1,99999999999)), //Use strong key for an external access
    "token2"=>sha1(rand(1,99999999999)), //Or use random key to disable it
));