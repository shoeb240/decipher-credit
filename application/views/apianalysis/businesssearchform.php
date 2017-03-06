<h1>Microbilt Business Search Service</h1>

<?php echo form_open('api/busconfirm'); ?>


<br />

<label>Company Name:</label><input type='text' name='cname' />
<br />

<label>City:</label><input type='text' name='city' />
<br />

<label>State:</label><input type='text' name='state' />
<br />

<label>Zip:</label><input type='text' name='zip' />

     <input type="submit" name="submit" value="Search" formnovalidate />

</form>