<?php
   define("ABSPATH", dirname(__FILE__));
   require_once( ABSPATH . '/lib/forms-entries.php' );
  
   $Title = "View Entries";
   $headerScripts = array("/scripts/form-builder/fbuilder.utils.js", 
						  "/scripts/form-builder/fbuilder.global.js", 
					      "/scripts/form-builder/fbuilder.layout.js", 
						  "/scripts/css_browser_selector.js",
						  "/scripts/form-builder/fbuilder.entries.js"
						  );
						  
   $headerStyles = array("/content/css/form-builder/forms-common.css",
						 "/content/css/form-builder/forms-interface.css"	
						);		
		

    $context_css = "forms-viewentries";							
   
?>

<?php include(ABSPATH . "/views/shared/forms-header.php"); ?>

<div class="form-page-container prepend-top span-26">        
    <div class="inner-container">        
		<a href="<?php echo rootUrl()?>/index.php" class="image-icon-link home-icon-link">Home</a>
		<br />
        <h2 class="form-title">
            Registration</h2>
        <small>(<?php echo count($formView->GroupedEntries)?> Entries Submitted)</small>        
    </div>        
    <div class="inner-container clear-both">
            <?php writeMessages();?><br />
			 <form action="<?php getLinkUrl("/actions.php?a=deleteentries"); ?>"  id="main-form" method="post">                
                <?php if (count($formView->GroupedEntries) > 0): ?>
                      <ul class="horizontal-list form-actions-list">
                    <li>
                        <input type="submit" class="red" value="Delete Selected" />                                                
						
						<a href="<?php getLinkUrl("/actions.php?a=export&id=" . $formView->Id) ?>" class="hyperlink-button green-button">Export All To Excel</a>
                    </li>
                    
                </ul>            
                      <div class="entries-container">
                    <table class="entries-table" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="select-field">
                                    <input id="select-all" class="select-all" type="checkbox" />
                                </th>
								<?php
                                $cellCount = 0;   
                                $colCount = count($formView->Fields) + 1;
                                $colWidth = 70;
                                if($colCount > 0){
                                    $colWidth = (768/$colCount) - 15;
                                }  
                                //<!--$colCount-->                   
								if(isset($formView->ColumnNames)){								
									foreach ($formView->ColumnNames as $column => $name)
									{
										
											echo "<th style='width:". $colWidth ."px;'>";
											echo   $name;
												$cellCount = $cellCount + 1;
											echo "</th>";                        
										
									}
								}
                                ?>
                                <th>
                                    Submitted
                                </th>
                            </tr>
                        </thead>
                        <tbody>
							<?php  foreach (array_values($formView->GroupedEntries) as $group): ?>
                                <tr class="tbl-body">
                                    <td class="select-field">
                                        <input class="select-item" value="<?php echo array_values($group)[0]->EntryId; ?>" name="selectedEntries[]" type="checkbox" />
                                    </td>
									<?php											
                                        $fieldAddedOn = array_values($group)[0]->DateAdded;
                                        foreach ($formView->ColumnNames as $column => $name)
                                        {
                                            $field = null;

                                            if (array_key_exists($column,$group))
                                            {
                                                $field = $group[$column];?>
                                            <td style="width:<?php echo $colWidth; ?>px">
                                            <?php echo $field->format(); ?>
                                            </td>   
                                           <?php  }else{ ?>
                                            <td>
                                                &nbsp;
                                            </td>   
                                            <?php }

                                        }
									?>
                                    <td>
                                        <?php echo outputHumanizedDate($fieldAddedOn);?>
                                    </td>
                                </tr>
                                                
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
               <?php else: ?>
                      <div class="notice">No entries have been submitted</div>
                <?php endif; ?>
                
				<input id="Id" type="hidden" value="<?php echo $formView->Id; ?>" name="Id">
				
            </form>            
        </div>    
</div>

<?php 
   function initializers()
   {
     echo "entries.init();";
   }   
?>



<?php include(ABSPATH . "/views/shared/forms-footer.php"); ?>

