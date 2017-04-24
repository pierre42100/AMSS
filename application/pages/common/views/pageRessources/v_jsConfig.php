<?php
/**
 * Javascript definition of the website
 *
 * @author Pierre HUBERT
 */

?><script>
/**
 * Website configuration
 */
var config = {};

/**
 * Website URL
 */
config.siteURL = "<?=site_url()?>";

<?php

//Check if user is logged in or not for some definition
if(AMSS::getInstance()->user->userLoggedIn()){
    
    //Protected definitions
    ?>
    /**
     * API URL
     */
    config.apiURL = "<?=site_url()?>api.php/";

    /**
     * Domain from which the mail may be send
     */
    config.sendDomain = "<?=AMSS::getInstance()->config->get("mailDomain")?>";
    <?php

}
?>

</script>