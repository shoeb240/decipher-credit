<?php

$item = json_decode($question);

?>

<link rel="stylesheet" type="text/css" media="screen" href="http://formbuilder.online/assets/css/form-builder.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
   <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
  

<script type="text/javascript">


jQuery(document).ready(function($) {
	  var fbTemplate = document.getElementById('fb-template'),
	    formContainer = document.getElementById('rendered-form'),
	    $fBInstance = $(document.getElementById('edit-form')),
	    formRenderOpts = {
	      container: $('form', formContainer)
	    };

	  $(fbTemplate).formBuilder();

	  $('.form-builder-save').click(function() {
	    $fBInstance.toggle();
	    $(formContainer).toggle();
	    $(fbTemplate).formRender(formRenderOpts);
	  });

	  $('.edit-form', formContainer).click(function() {
	    $fBInstance.toggle();
	    $(formContainer).toggle();
	  });
	});

</script>


<!-- <div id="edit-form">
<textarea id="fb-template">
<form-template>
    <fields>
    <div class="form-group field-checkbox-1465213444022">
    <field name="checkbox-1465213444022" class="checkbox" id="checkbox-1465213444022" type="checkbox"></field>
     <label for="checkbox-1465213444022">Checkbox  </label></div>
     <div class="form-group field-select-1465213449047">
     <label for="select-1465213449047">Select  </label><select type="select" name="select-1465213449047" class="form-control select" id="select-1465213449047">
     <option value="option-1">Option 1</option><option value="option-2">Option 2</option></select>
     </div>
     <div class="form-group field-file-1465213445144">
     <label for="file-1465213445144">File Upload  </label> 
     <input name="file-1465213445144" class="form-control file-input" id="file-1465213445144" type="file"></div>
     <div class="form-group field-text-1465213938897">
     <label for="text-1465213938897">Text Field <span class="required">*</span> </label> 
     <input subtype="text" required="" name="text-1465213938897" class="form-control text-input" id="text-1465213938897" aria-required="true" type="text">
     </div>
     <div class="form-group field-radio-group-1465213447506">
     <label for="radio-group-1465213447506">Radio Group  </label>
     <div class="radio-group"><input name="radio-group-1465213447506" class="radio-group" id="radio-group-1465213447506-0" value="option-1" type="radio"> 
     <label for="radio-group-1465213447506-0">Option 1</label><br>
     <input name="radio-group-1465213447506" class="radio-group" id="radio-group-1465213447506-1" value="option-2" type="radio"> 
     <label for="radio-group-1465213447506-1">Option 2</label><br></div>
     </div>
    </fields>
  </form-template>


</textarea> 
</div>
<div id="rendered-form">
  <form action="#">
  
  
  
  </form>
  <button class="btn btn-default edit-form">Edit</button>
</div> -->

<?php echo validation_errors(); ?>

<div class="row">
    <div class="col-md-12">
        
        <?php echo form_open('questions/edit/'.$item->id); ?>
        
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">Question Label:</div>
                <div class="col-md-3">
                    <input type="text" id="des" name="des" class="form-control" value="<?php echo $item->des; ?>">
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">Type:</div>
                <div class="col-md-3">
                    <input type="text" id="type" name="type" class="form-control" value="<?php echo $item->type; ?>">
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">Weight:</div>
                <div class="col-md-3">
                    <input type="text" id="weight" name="weight" class="form-control" value="<?php echo $item->weight; ?>">
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">Output Type:</div>
                <div class="col-md-3">
                    <!-- <input type="text" id="des" name="outputType" value="<?php echo $item->outputType; ?>"> -->
                    <select id="outputType" name="outputType" class="form-control">
                        <?php foreach($output_types as $each):?>
                        <option <?php echo ($each['id'] == $item->outputType ? 'Selected="selected"' : '');?> value="<?php echo $each['id'];?>"><?php echo $each['description'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">Status:</div>
                <div class="col-md-3">
                    <!-- <input type="text" id="status" name="status" class="form-control" value="<?php echo $item->status; ?>"> -->
                    <select name="status" class="form-control">
                        <?php foreach($statuses as $each):?>
                        <option <?php echo ($each['ID'] == $item->status ? 'Selected="selected"' : '');?> value="<?php echo $each['ID'];?>"><?php echo $each['Description'];?></option>
                        <?php endforeach;?>
                    </select>  
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">Parameters:</div>
                <div class="col-md-3">
                    <textarea id="parameters" name="parameters" class="form-control" style="width: 100%"><?php echo $item->parameters; ?></textarea> 
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-2">&nbsp;</div>
                <div class="col-md-2">Question:</div>
                <div class="col-md-6">
                    <textarea id="content" name="content" class="form-control" style="width: 100%"><?php echo $item->content; ?></textarea> 
                </div>
            </div>
        
        <div class="row" style="clear:both;">
                <div class="col-md-4">&nbsp;</div>
                <div class="col-md-8" style="margin-top: 10px;">
                    <input type="submit" name="submit" class="btn btn-primary " value="Update Question" />
                </div>
            </div>
            
        </form>

    </div>
</div>