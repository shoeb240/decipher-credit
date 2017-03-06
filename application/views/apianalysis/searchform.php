
<?php echo form_open('api/mform'); ?>


<label>First Name: </label> <input type="text" name="fname" />
<br />
<label>Last Name: </label> <input type="text" name="lname" />
<br />

<label>SSN: </label> <input type="text" name="ssn" />
<br />

<label>Email: </label> <input type="text" name="email" />
<br />


<label>Street Number: </label> <input type="text" name="streetnum" />
<br />

<label>Street Name (no number) Only: </label> <input type="text" name="street" />
<br />

<label>City: </label> <input type="text" name="city" />
<br />

<label>State: </label> <input type="text" name="state" />
<br />

<label>ZIP: </label> <input type="text" name="zip" />
<br />


     <input type="submit" name="submit" value="Search" formnovalidate />

</form>