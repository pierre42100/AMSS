<?php
/** 
 * Head of page main ressources
 *
 * @author Pierre HUBERT
 */
?>

<!-- Bootstrap main stylesheet -->
<?php echo incCSScode(path_assets("adminLTE/bootstrap/css/bootstrap.min.css")); ?>

<!-- adminLTE style -->
<?php echo incCSScode(path_assets("adminLTE/dist/css/AdminLTE.min.css")); ?>
<?php echo incCSScode(path_assets("adminLTE/dist/css/skins/_all-skins.min.css")); ?>

<!-- Font awesome icons -->
<?php echo incCSScode(path_assets("adminLTE/plugins/font-awesome/css/font-awesome.min.css")); ?>

<!-- Wysihtml5 - text editor -->
<?php echo incCSScode(path_assets("adminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")); ?>

<!-- Datepicker -->
<?php echo incCSScode(path_assets("adminLTE/plugins/datepicker/datepicker3.css")); ?>

<!-- Timepicker -->
<?php echo incCSScode(path_assets("adminLTE/plugins/timepicker/bootstrap-timepicker.min.css")); ?>

<!-- Main project stylesheet -->
<?=inc_css_asset("common/main")?>