
<?php echo form_open('handlers/edit/'.$hand_data[0]->id); ?>

<div class="container">
<div class="row">
<div class="col-md-6 pull-left">
	<div class="row">
	 
	 <div class="col-md-4">
    <div class="form-group">    
     <input type="text"  name="description" id="description" class="form-control" placeholder="Description" value="<?php echo $hand_data[0]->description; ?>" required />       
    </div>
	</div>
	<div class="col-md-4">
    <div class="form-group"> 
	 <input type="text"  name="handler" id="handler" class="form-control" placeholder="Handler" value="<?php echo $hand_data[0]->handler; ?>" />	
	 </div>
	 </div>
</div>



</div>


</div>




</div>
<div class="row">
<div class="col-md-4 pull-right">

    <div class="form-group">
     <input type="submit" name="submit" class = "btn btn-primary" value="Update handler item" formnovalidate />
</div>
</div>
</div>
</form>