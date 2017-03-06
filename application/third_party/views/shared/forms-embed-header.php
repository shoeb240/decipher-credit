<!DOCTYPE html>
<html lang="en">
    <head>
	<?php
      $sitePath = '';	
	  $pageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	  $fullurl =  rtrim($protocol . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], "/");
      $details = parse_url($fullurl);
	  $path = isset($details["path"]) ? $details["path"] : "";
      $docRoot = $protocol . $_SERVER['HTTP_HOST'] . "/" . str_replace($pageName, "", $path);
      	  
	  if(!isset($context_css)){
	     $context_css = "forms-index";
	  }
	?>
        <meta charset="utf-8" />
        <title><?php echo $Title; ?> - Drag N' Drop FormBuilder</title>
        <link href="~/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <meta name="viewport" content="width=device-width" />          
        <!--javascripts-->
        <script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery-1.7.1.min.js"></script>  
		<script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery.cookie.js"></script>
		<script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery-ui-1.8.20.js"></script> 
		<script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery-ui-i18n.all.min.js"></script>
        <script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery.tipsy.js"></script>
		<script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery.maxlength-min.js"></script>
        <script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery.unobtrusive-ajax.min.js"></script>		
		<script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/jquery.numeric.js"></script>		                 
        <script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/form-builder/fbuilder.utils.js"></script>
        <script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/form-builder/fbuilder.global.js"></script>   
        <script type="text/javascript" src="<?php echo $docRoot; ?>/scripts/css_browser_selector.js"></script>     
		
		<?php 
		   if(isset($headerScripts) && !is_null($headerScripts)){
		       foreach($headerScripts as $script)
			   {
				  echo "<script type=\"text/javascript\" src=\"" . $docRoot . $script . "\"></script>\n";
			   }
			}		
		?>

        <!--css-->    
        <link type="text/css" href="<?php echo $docRoot; ?>/content/css/reset.css" rel="stylesheet"  />
        <link type="text/css" href="<?php echo $docRoot; ?>/content/css/blueprint/screen.css" rel="stylesheet"  />        
        <link type="text/css" href="<?php echo $docRoot; ?>/content/css/plugins/tipsy.css" rel="stylesheet"  />
		<link type="text/css" href="<?php echo $docRoot; ?>/content/themes/base/jquery.ui.core.css" rel="stylesheet"  />
		<link type="text/css" href="<?php echo $docRoot; ?>/content/themes/base/jquery.ui.datepicker.css" rel="stylesheet"  />
		<link type="text/css" href="<?php echo $docRoot; ?>/content/themes/base/jquery.ui.theme.css" rel="stylesheet"  />
        <link type="text/css" href="<?php echo $docRoot; ?>/content/css/form-builder/forms-global.css" rel="stylesheet"  />                
        <link type="text/css" href="<?php echo $docRoot; ?>/content/css/form-builder/forms-sprites.css" rel="stylesheet"  />          
		<link type="text/css" href="<?php echo $docRoot; ?>/content/css/form-builder/forms-embed.css" rel="stylesheet"  /> 
        <?php
			if(isset($headerStyles) && !is_null($headerStyles)){
			   foreach($headerStyles as $style)
			   {
				  echo "<link type=\"text/css\" href=\"" . $docRoot . $style . "\" rel=\"stylesheet\" />\n";
			   }
			}
		?>
    </head>
    <body class="<?php echo $context_css; ?>">        
    <div>