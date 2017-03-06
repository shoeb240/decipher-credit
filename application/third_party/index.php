<?php

   define("ABSPATH", dirname(__FILE__));
   require_once(ABSPATH . '/lib/forms-common.php' );   
   require_once(ABSPATH . '/lib/forms-index.php' );   
  
   $Title = "Welcome to Form Builder";
   $headerScripts = array();   
   $is_connection_ready = !isset($db_connection_error ) || (isset($db_connection_error) && $db_connection_error==false);   
   $formCount = 0;
   if (isset($formViewsList)){
	 $formViews = $formViewsList->FormViews;
	 $formViewTemplates = $formViewsList->FormViewTemplates;
	 $formCount = count($formViews);
   }
   
?>
<?php include("views/shared/forms-header.php"); ?>
<?php if (empty($formViews) || !$is_connection_ready) { ?>
    <div class="select-form-container align-center welcome-container">
		<?php if ($is_connection_ready == false){?>
		   <div class="notice">
		      NOTE: A valid database connection has not been made. Go to <i>"/lib/forms-settings.php"</i> in your installation directory to input your database settings.
		   </div>
	   <?php } ?>
       <img src="<?php echo $docRoot; ?>/content/images/spacer.gif" class="image-bg form-icon" alt="form icon" /><br />
	   <?php if ($is_connection_ready != false){?>
       <h3 class="welcome-text">Welcome to the Decipher form builder. You have not yet created any template. Click the button below to begin</h3>
       <a href="<?php echo $docRoot; ?>/actions.php?a=create" class="hyperlink-button light-blue-button welcome-button">Create Template</a>		   
	   <?php }else{?>
	   <h3 class="welcome-text">Welcome to the Decipher form builder. Setup your database to begin creating forms</h3>
	   <?php }?>
    </div>
<?php 
}else{
    $counter = 0;
?>
   
   <?php writeMessages(); ?>
   
    <div class="select-form-container">
    <div class="add-form-guide info align-left welcome-instructions">
		<?php echo Constants::WELCOME_MESSAGE; ?>
    </div>
    <div class="add-form-button-container  <?php echo (Settings::SHOW_UPDATE_TEMPLATES_BUTTON === true) ? "show-update-templates" : ""; ?>">
		<ul class="horizontal-list right select-template-list">
			<li class="dropdown-field">
				
					<div class="dropdown">
						<select id="templates" class="select- dropdown-select" 
								data-copy-link='<?php echo getLinkUrl("/actions.php?a=copy&is-ajax=true");?>'
								data-create-link='<?php echo $docRoot; ?>/actions.php?a=create'>
							<option value="-1" selected="selected"><?php echo count($formViewTemplates) > 0 ? "Select a Template" : "No templates have been added" ?></option>
							<?php if (count($formViewTemplates) > 0): ?>
								<?php foreach($formViewTemplates as $template): ?>
									<option value="<?php echo $template->Id;?>"><?php echo $template->Title; ?></option>
								<?php endforeach; ?>
							<?php endif;?>
						</select>					
					</div>
				
			</li>
			<li class="button-field">
				<a  id="add-form-button" href="javascript:void(0);" class="hyperlink-button black-button add-form-button">Add Form</a>
				<?php if(Settings::SHOW_UPDATE_TEMPLATES_BUTTON === true){ ?>					
					<a  id="update-templates-button" 
					    href="javascript:void(0);" 
						data-update-templates-link="<?php echo getLinkUrl("/actions.php?a=update-templates&is-ajax=true");?>" 
						class="hyperlink-button light-blue-button add-form-button">Update Templates</a>
				<?php } ?>
			</li>
		</ul>		
    </div>
    <table class="main-table">
    <thead>
      <tr>
        <th><h3>Form List</h3></th>        
        <th>&nbsp;</th>
      </tr>      
    </thead>
    <tbody>
    <?php foreach ($formViews as $f): ?>
          <?php if ($f->IsTemplate == false || ($f->IsTemplate==true && Settings::SHOW_TEMPLATES_IN_LIST == true)): ?>  
       <tr class="form-item-row">
       <td class="title-column">         
		 <span class="title"><?php echo $f->Title; ?></span>
		 <a class="image-icon-link copy-icon-grey-link copy-form-link" 
			title="copy form" 
			href="javascript:void(0);" 
			data-copy-link='<?php echo getLinkUrl("/actions.php?a=copy&is-ajax=true&id=" . $f->Id);?>'></a>
		 <br />
         <span class="date"><?php outputHumanizedDate($f->DateAdded); ?></span>
       </td>       
        <td>
		  <?php if (Settings::SHOW_TEMPLATES_IN_LIST == true){ ?>
			<input type="checkbox" id="templatize" <?php echo $f->IsTemplate ? 'checked="checked"' : ""; ?> data-formid=<?php echo $f->Id; ?> title="Toggle Template Status">
		  <?php } ?>
		  <a href="<?php echo rootUrl(); ?>/edit.php?id=<?php echo $f->Id?>" class="hyperlink-button light-blue-button">Edit Form</a>
		  <a href="<?php echo rootUrl(); ?>/view.php?id=<?php echo $f->Id?>" class="hyperlink-button green-button">View/Fill Form</a>
		  <a href="<?php echo rootUrl(); ?>/entries.php?id=<?php echo $f->Id?>" class="hyperlink-button orange-button">View Entries</a>
           &nbsp;
          <a href="<?php echo rootUrl(); ?>/actions.php?a=delete&id=<?php echo $f->Id; ?>" onclick="return confirm('Are you sure you would like to delete this form?');" title="Delete Form" class="image-bg-link image-bg delete-icon-link">&nbsp;</a>
         
        </td>
        </tr>         
          <?php $counter++; ?>
		<?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
<?php } ?>

<?php include("views/shared/forms-footer.php"); ?>
