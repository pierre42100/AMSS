<?php
/**
 * Mail default configuration
 *
 * @author Pierre HUBERT
 */

/**
 * Domain from which mails may be sent from
 */
$config->set("mailDomain", "mail.local");

/**
 * Email address which may receive an hidden copy of all the mails
 *
 * Values :
 * - False : disable feature
 * - String : The target email address 
 */
$config->set("emailAddressCC", "someone@example.com");

/**
 * Default mail address for sender
 */
$config->set("defaultMailAddress", "admin@example.com");

/**
 * Default name for sender
 */
$config->set("defaultMailSender", "AMSS");

/**
 * Default message content
 */
$config->set("defaultMessage", "<p>Some default content</p>");