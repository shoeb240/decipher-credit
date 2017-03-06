<script id="form-field-formbreak-template" type="text/x-jquery-tmpl">
<div class="input">
    <ul class="horizontal-list entry-form-list wizard-buttons">
        <li class="previous-button-item">
           <input type="submit" class="save-button grey" data-sub-channel="sub-previoustext-${id}" value="<?php echo Constants::DEFAULT_PREVIOUS_TEXT; ?>">
		</li>
		<li class="button-separator-item">
		&nbsp;
		</li>
        <li class="next-button-item">
            <input type="submit" class="save-button blue" data-sub-channel="sub-nexttext-${id}" value="<?php echo Constants::DEFAULT_NEXT_TEXT; ?>">
		</li>
    </ul>
   <?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>