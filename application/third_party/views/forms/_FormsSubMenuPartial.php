<ul class="form-actions-menu horizontal-list left clear">
     <li>       
	   <a href="<?php echo rootUrl();?>/index.php" class="image-icon-link home-icon-link">Home</a>
     </li>
     <li class="seperator-item <?php echo strtolower($formView->Status); ?>">&nbsp;</li>
    <li><a href="javascript:void(0);" class="image-icon-link save-icon-link submit-link save-button">
        <span>Save</span></a></li>
    
    
    <?php if ($formView->Status == "PUBLISHED") {?>
        <li class="preview-item"><a href="<?php echo $formView->previewUrl(); ?>" target="_blank" class="image-icon-link preview-icon-link"><span>
        Preview</span></a></li>
        
        <li class="embed-item"><a href="javascript:void(0);" id="embed-link" class="image-icon-link embed-icon-link"><span>
        Embed</span></a></li>
        
        <li class="publish-item <?php outputIfFalse(count($formView->Fields) > 0, "hide") ?>"><a href="<?php getLinkUrl("/actions.php?a=toggle-publish", array("to_on" => "false", "id" => $formView->Id)); ?>" class="image-icon-link crossbox-icon-link">
            <span>Unpublish</span></a>
		</li>
    <?php }
    else
    { ?>
        <li class="publish-item <?php outputIfFalse(count($formView->Fields) > 0, "hide") ?>"><a href="<?php getLinkUrl("/actions.php?a=toggle-publish", array("to_on" => "true", "id" => $formView->Id)); ?>" class="image-icon-link speaker-icon-link">
            <span>Publish</span></a></li>
   <?php } ?>
    
    <?php if (isset($formView->GroupedEntries) && $formView->GroupedEntries != null && count($formView->GroupedEntries) > 0) {?>
    
        <li><a href="<? getLinkUrl("/view.php", array("id" => $formView->id)); ?>" class="image-icon-link invitations-icon-link">
            <span>View Entries  <?php outputIfTrue(count($formView.GroupedEntries) > 0, strFormat("{0}", count($formView.GroupedEntries))); ?></span></a></li>
    <?php } ?>
    
    <li><?php spinner(); ?></li>
</ul>
