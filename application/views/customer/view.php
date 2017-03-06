<script>
function show_field_div(field_name, user_id)
{
    $("#"+field_name+"_label_div_"+user_id).css("display", "none");
    $("#"+field_name+"_field_div_"+user_id).css("display", "block");
}

function cancel_field_div(field_name, customer_id)
{
    $("#"+field_name+"_label_div_"+customer_id).css("display", "block");
    $("#"+field_name+"_field_div_"+customer_id).css("display", "none");
}

function save_field(field_name, customer_id)
{
    var field_value = $("#"+field_name+"_field_"+customer_id).val();
    var values = "var values = {'customer_id': '" + customer_id + "', '" + field_name + "': '" +  escape(field_value) + "'};";
    console.log(values);
    eval(values);
    $.ajax({
        url: '../ajax/Customer_ajax/SaveCustomer',
        type: 'POST',
        data: values,
        dataType: 'json',
        async: false,
        success: function(result){
            console.log(result);
            if (result.response !== false ) {
                $("#"+field_name+"_label_"+customer_id).html(field_value);
                $("#"+field_name+"_label_"+customer_id).attr("class", "link_normal");
                $("#"+field_name+"_label_div_"+customer_id).css("display", "block");
                $("#"+field_name+"_field_div_"+customer_id).css("display", "none");
            } else {
                alert('Failed to save');
            }
        }
    });

}
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 pull-left">
        
            <div class="panel panel-default">
              <div class="panel-heading">
                  <h4>Customer List</h4>
                  <p>Below is a lsit of all customers</p>
                  <div id="infoMessage"><?php //echo $message;?></div>
              </div>
              <div class="table-fixedheader">
            <table style="width: 100%" class="table-striped table-condensed table-bordered table-hover">
                <tbody class="connectedSortable">
                    <tr>
                            <th>Customer Name</th>
                    </tr>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td>
                                <div id="nameLast_label_div_<?php echo $customer->id;?>">
                                    <a id="nameLast_label_<?php echo $customer->id;?>" class="<?php echo $customer->nameLast ? 'link_normal' : '';?>" href="javascript:void(0);" onclick="show_field_div('nameLast', '<?php echo $customer->id;?>')">
                                        <?php echo htmlspecialchars($customer->nameLast,ENT_QUOTES,'UTF-8');?>
                                    </a>
                                </div>
                                <div id="nameLast_field_div_<?php echo $customer->id;?>" style="display: none;  float: left;">
                                    <div>
                                        <input type="text" id="nameLast_field_<?php echo $customer->id;?>" value="<?php echo htmlspecialchars($customer->nameLast,ENT_QUOTES,'UTF-8');?>" />
                                    </div>
                                    <div style="clear: both;">
                                        <a href="javascript:void(0);" onclick="save_field('nameLast', '<?php echo $customer->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/save-icon.png'?>" /></a>
                                        <a href="javascript:void(0);" onclick="cancel_field_div('nameLast', '<?php echo $customer->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/cancel-icon.png'?>" /></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

                  </div>
            </div>
            
            <p><?php echo anchor('customers/create', 'Create Customer')?></p>
            
        </div>      
    </div>
</div>

