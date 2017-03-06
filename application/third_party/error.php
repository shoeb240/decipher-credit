<?php
   
   define("ABSPATH", dirname(__FILE__));
   require_once(ABSPATH . '/lib/forms-common.php' );
   require_once( ABSPATH . '/lib/forms-html-utils.php' );
  
   $Title = "FormBuilder";
   $headerScripts = array();
?>

<?php include("views/shared/forms-header.php"); ?>
    <div class="select-form-container align-center welcome-container">
       <?php writeMessages() ?>
    </div>
<?php include("views/shared/forms-footer.php"); ?>

