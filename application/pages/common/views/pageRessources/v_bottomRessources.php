<?php
/**
 * End of page ressources
 *
 * @author Pierre HUBERT
 */
?>

 <!-- Jquery -->
<?php echo incJScode(path_assets("adminLTE/plugins/jQuery/jquery-2.2.3.min.js")); ?>

<!-- Bootstrap -->
<?php echo incJScode(path_assets("adminLTE/bootstrap/js/bootstrap.min.js")); ?>

<!-- adminLTE -->
<?php echo incJScode(path_assets("adminLTE/dist/js/app.min.js")); ?>

<!-- Wysihtml5 - text editor -->
<?php echo incJScode(path_assets("adminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")); ?>

<!-- Datepicker -->
<?php echo incJScode(path_assets("adminLTE/plugins/timepicker/bootstrap-timepicker.min.js")); ?>

<!-- Timepicker -->
<?php echo incJScode(path_assets("adminLTE/plugins/datepicker/bootstrap-datepicker.js")); ?>

<!-- Common utilities -->
<?=inc_js_asset("common/utils")?>

<!-- Values checker -->
<?=inc_js_asset("common/checkFormValues")?>

<!-- AMSS object main definition -->
<?=inc_js_asset("AMSS")?>

<!-- Information messages tool -->
<?=inc_js_asset("common/informations")?>

<!-- AMSS api definitions -->
<?=inc_js_asset("common/api")?>

<!-- AMSS mails common functions -->
<?=inc_js_asset("common/mails")?>