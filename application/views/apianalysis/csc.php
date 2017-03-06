<?php echo form_open('api/csc'); ?>
    Company Name: <input type="text" name="company" value="<?php echo $company; ?>">
    <br>
    State Postal Code: <input type="text" name="state" value="<?php echo $state; ?>">
    <br>
    <input type="submit" name="search" value="Search">
</form>

<?php echo ($result ? '<textarea rows="30" cols="150" style="border:none;">' . $result . '</textarea>' : 'No search results.'); ?>
