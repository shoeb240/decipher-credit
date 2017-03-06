<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1 style="text-align: center; margin-bottom: 30px;">Create New Customer</h1>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  
<?php echo validation_errors(); ?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        
        <form method="post" action="create">
        
<!--        <div class="row">
            <div class="col-md-2">Id:</div>
            <div class="col-md-3">
                <input type="text" id="id" name="id" class="form-control" value="">  remove 
            </div>
        </div>-->
            
        <div class="row">
            <div class="col-md-2">Customer Name:</div>
            <div class="col-md-3">
                <input type="text" id="nameLast" name="nameLast" class="form-control" value="">
            </div>
        </div>

        <div class="row" style="clear:both;">
            <div class="col-md-2">&nbsp;</div>
            <div class="col-md-8" style="margin-top: 10px;">
                <input type="submit" name="submit" class="btn btn-primary " value="Create Customer" />
            </div>
        </div>
            
        </form>

    </div>
</div>
