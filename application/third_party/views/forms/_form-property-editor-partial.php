<ul class="vertical-list">
    <li class="header static-assets/sidebar-header-full.png">
        <h3 class="sponsors properties-header">
            Form Properties			
	   </h3>
	   <a href="javascript:void(0);" class="image-icon-link the-pin-icon pinned-icon-link" title="Unpin property editor"></a>
    </li>
    <li>
        <table id="form-property-table" class="form-field-properties field-property-table" cellpadding="0" cellspacing="0">
            <!-- field label -->
            <tr>
                <td class="label">
                    <label class="label">
                        Title</label>
                </td>
                <td class="input">                    
				   <input id="Title" class="is-publisher" type="text" value="<?php echo $formView->Title; ?>" name="Title" maxlength="20" data-sub-channel="sub-title-0" data-field-property="title">
                   <input id="Status" type="hidden" value="<?php echo $formView->Status; ?>" name="Status" data-val-required="The Status field is required." data-val="true">
                </td>
            </tr>                    
            <tr>
                <td class="label">
                    <label class="label">
                        Theme</label>
                </td>
                <td class="input">
                    <select name="Theme" id="Theme" data-field-property="Theme" class="is-publisher">					   
						<option value="" <?php echo (isNullOrEmpty($formView->Theme) ? "selected='selected'" : ""); ?>></option>						
						<?php foreach($form_themes as $key=>$value){ ?>						    
						      <option value="<?php echo $value; ?>" <?php outputIfTrue($formView->Theme == $value,"selected='selected'") ?>><?php echo $value; ?></option>
						<?php }?>
						
					</select>
                </td>
            </tr>  
            <tr>
                <td class="label">
                    <label class="label">
                        Notification Email</label>
                </td>
                <td class="input">
                    <input type="text" value="<?php echo $formView->NotificationEmail; ?>" name="NotificationEmail" id="NotificationEmail">
                </td>
            </tr>
			<tr>
                <td class="label">
                    <label class="label">
                       Redirect Url</label>
                </td>
                <td class="input">
                    <input type="text" value="<?php echo $formView->RedirectUrl; ?>" name="RedirectUrl" id="RedirectUrl">
                </td>
            </tr>
			<tr class="hide">
                <td class="label">
                    <label class="label">
                       Allow Save</label>
                </td>
                <td class="input">
                    <select name="AllowSave" id="AllowSave" data-field-property="AllowSave">					   
						<option value="No" <?php echo ( !$formView->AllowSave ? "selected='selected'" : ""); ?>>No</option>												
						<option value="Yes" <?php echo ( $formView->AllowSave ? "selected='selected'" : ""); ?>>Yes</option>																								
					</select>
                </td>
            </tr>
			<tr>
                <td class="label">
                    <label class="label">
                       Submit Text</label>
                </td>
                <td class="input">
                    <input type="text" class="is-publisher" data-sub-channel="submit-button-0" value="<?php echo $formView->SubmitButtonText; ?>" name="SubmitButtonText" id="SubmitButtonText">
                </td>
            </tr>			
            <!-- Confirmation message -->
            <tr class="last-row">
                <td class="label">
                    <label class="label">
                        Confirmation Msg</label>
                </td>
                <td class="input">
                    <textarea rows="2" name="ConfirmationMessage" maxlength="200" id="ConfirmationMessage" cols="20" class="elastic"><?php echo $formView->ConfirmationMessage; ?></textarea>
                </td>
            </tr>                 
        </table>
    </li>
</ul>
