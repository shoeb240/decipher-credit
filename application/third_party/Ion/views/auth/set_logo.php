<div class="row col-md-12">
        <div class="col-md-4" style="float: left;"></div>
        <div class="col-md-6" style="float: left;">
            <h2>Upload Logo</h2>
            <p></p>

            <div id="infoMessage"><?php echo validation_errors(); ?><?php echo $message;?></div>

            <?php echo form_open_multipart('auth/set_logo');?>

            <input type="file" name="logo" size="20" />

            <input type="submit" name="submit" value="upload" />

            <?php echo form_close();?>
            
        </div>
    </div>

    <div style="clear: both;"></div>



