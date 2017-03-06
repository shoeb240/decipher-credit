<?php

   define("ABSPATH", dirname(__FILE__));
   require_once(ABSPATH . '/lib/forms-common.php' );	
   require_once( ABSPATH . '/lib/forms-confirmation.php' );
  
   $Title = "Edit Form";
						  
   $headerStyles = array("/content/css/form-builder/forms-interface.css");	
     
   // set theme style
   if(isset($formView->Theme) && !empty($formView->Theme) && isNullOrEmpty($formView->RedirectUrl)){   
      array_push($headerStyles, "/content/css/form-builder/themes/" . $formView->Theme . "/styles.css");
   }

    $context_css = "forms-confirmation";							
	$formView->Embed=true;
    $context_css = "forms-register";
    $embedLayoutPrefix = $formView->Embed ? "forms-embed-" : "";		
	define("FORMID", $formView->Id);
?>

<?php include(ABSPATH . "/views/shared/" . $embedLayoutPrefix . "header.php"); ?>

<div class="form-page-container confirmation-page-container prepend-top span-26 <?php echo  (!isNullOrEmpty($formView->RedirectUrl) ? "hide" : ""); ?>">        
        <div class="inner-container">
            <h2 class="title"></h2>
            <h4 class="date"></h4>
        </div>         
            <br />

        <div class="inner-container">
			<?php writeMessages(); ?>
			<br />
			<a href="<?php echo $formView->Url(); ?>">Click Here</a> to go back
		</div>    
</div>
<?php 
   function initializers()
   {	   
       
		  echo " $.get('" . returnLinkUrl('/actions.php?a=get-content&c=redirecturl&formid='. FORMID) . "', function(data){" .			   
			   "	   if(data.url != ''){ " .			   
			   "         window.top.location.href=data.url; " .
			   "	   } " .
		       "})";
   }   
?>

<?php include(ABSPATH . "/views/shared/". $embedLayoutPrefix ."footer.php"); ?>

