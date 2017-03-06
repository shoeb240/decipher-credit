<script id="form-field-address-template" type="text/x-jquery-tmpl">
<label data-sub-channel="sub-label-${id}" class="label editable">Click to edit</label>
  <span class="required hidden">*</span>
<div class="input">
  <ul class="vertical-list">
  <li>
  <input type="text" class="title" /><br />
   <span class="sub-label">Street address</span>
  </li>
  <li>
  <input type="text" class="title" /><br />
   <span class="sub-label">Street address 2</span>
  </li>
  <li>
     <ul class="two-field-row entry-form-list horizontal-list">
       <li>
         <input type="text" class="title shorter-field" /><br />
        <span class="sub-label">City</span>
       </li>
       <li>
       <input type="text" class="shorter-field title" /><br />
        <span class="sub-label">State / Province</span>
       </li>
     </ul>
  </li>
  <li>
    <ul class="two-field-row horizontal-list entry-form-list">
       <li>
       <input type="text" class="shorter-field title" maxlength="5" /><br />
        <span class="sub-label">zip code</span>
       </li>
       <li>         
		 <?php countrySelectList("Countries", "shorter-field", "Select Country"); ?>
		 <br/>
         <span class="sub-label">Country</span>
       </li>
    </ul>
  </li>
  </ul>
<?php include(ABSPATH . "/views/forms/_form-field-properties.php"); ?>
</div>
<a href="javascript:void(0);" class="help-icon-1 help-icon hide w-tip">
  <img src="<?php spacerImage(); ?>" alt="help" />
</a>
<?php include(ABSPATH . "/views/forms/_form-field-settings-template.php"); ?>
</script>


