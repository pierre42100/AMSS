<?php
/**
 * End of page scripts ressources inclusion for compose page
 *
 * @author Pierre HUBERT
 */

?>
<!-- Include main compose scripts -->
<?=inc_js_asset("compose/compose")?>

<!-- Adapt the name of the webpage -->
<script>
    //Set a new title
    document.title = "<?=$pageDescription?>";
</script>