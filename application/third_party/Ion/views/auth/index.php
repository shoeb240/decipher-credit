<?php
    foreach($customers as $customer):
        $option_customers[] = array(
                $customer['id'] => $customer['nameLast'] 
        );
        $st = 'multiple style="width:100%"';
    endforeach;
    
    foreach($groups as $group):
        $option_groups[] = array(
                $group['id'] => $group['name'] 
        );
        $st = 'multiple style="width:100%"';
    endforeach;
?>

<style>
    a.link_normal {
        color: #333;
        
    }
    a.link_normal:hover {
        text-decoration: none;
        
    }
    img.save_cancel_img {
        margin-left: 5px;
        width: 12px;
    }
    input {
        width: 120px;
    }
    </style>

<script>
    function show_select_div(user_id)
    {
        var div_id = "#customer_select_div_" + user_id;
        var cust_name_list_id = "#customer_name_list_" + user_id;
        $(div_id).css('display', 'block');
        $(cust_name_list_id).css('display', 'none');
    }
    
    function cancel_select_div(user_id)
    {
        var div_id = "#customer_select_div_" + user_id;
        var cust_name_list_id = "#customer_name_list_" + user_id;
        $(div_id).css('display', 'none');
        $(cust_name_list_id).css('display', 'block');
    }
    
    function save_customer(user_id)
    {
        var select_id = "select#customer_select_" + user_id + " :selected";
        var cust_name_list_id = "#customer_name_list_" + user_id;
        var cust_id_list = '';
        var cust_name_list = '';
        
        $(select_id).each(function(){
            if (cust_name_list != '') cust_name_list += '<br>';
            if (cust_id_list != '') cust_id_list += ',';
            cust_name_list += $(this).text();
            cust_id_list += $(this).val();
        });
        
        if (!cust_id_list && $(cust_name_list_id).html() == 'Add') {
            alert('No customer selected');
            return false;
        }
        
        if (cust_name_list == $(cust_name_list_id).html()) {
            alert('No new customer selected');
            return false;
        }
        
        $.ajax({
            url: '../ajax/Customer_ajax/SaveCustomerUsers',
            type: 'POST',
            data: {'cust_id_list': cust_id_list, 'user_id': user_id},
            dataType: 'json',
            async: false,
            success: function(result){
                //console.log(result);
                if (result.response !== false ) {
                    if (!cust_name_list) {
                        cust_name_list = 'Add';
                        $(cust_name_list_id).attr("class", "");
                    } else {
                        $(cust_name_list_id).attr("class", "link_normal");
                    }
                    $(cust_name_list_id).html(cust_name_list);
                    cancel_select_div(user_id);
                } else {
                    alert('Failed to add customer');
                }
            }
        });
    }
    
    function show_group_select_div(user_id)
    {
        var div_id = "#group_select_div_" + user_id;
        var group_name_list_id = "#group_name_list_" + user_id;
        $(div_id).css('display', 'block');
        $(group_name_list_id).css('display', 'none');
    }
    
    function cancel_group_select_div(user_id)
    {
        var div_id = "#group_select_div_" + user_id;
        var group_name_list_id = "#group_name_list_" + user_id;
        $(div_id).css('display', 'none');
        $(group_name_list_id).css('display', 'block');
    }
    
    function save_group(user_id)
    {
        var select_id = "select#group_select_" + user_id + " :selected";
        var group_name_list_id = "#group_name_list_" + user_id;
        var group_id_list = '';
        var group_name_list = '';
        
        $(select_id).each(function(){
            if (group_name_list != '') group_name_list += '<br>';
            if (group_id_list != '') group_id_list += ',';
            group_name_list += $(this).text();
            group_id_list += $(this).val();
        });
        
        if (!group_id_list && $(group_name_list_id).html() == 'Add') {
            alert('No group selected');
            return false;
        }
        
        if (group_name_list == $(group_name_list_id).html()) {
            alert('No new group selected');
            return false;
        }
        
        $.ajax({
            url: '../ajax/Auth_ajax/SaveGroupUsers',
            type: 'POST',
            data: {'group_id_list': group_id_list, 'user_id': user_id},
            dataType: 'json',
            async: false,
            success: function(result){
                console.log(result);
                if (result.response !== false ) {
                    if (!group_name_list) group_name_list = 'Add';
                    $(group_name_list_id).html(group_name_list);
                    cancel_group_select_div(user_id);
                } else {
                    alert('Failed to add group');
                }
            }
        });
    }
    
    function show_field_div(field_name, user_id)
    {
        $("#"+field_name+"_label_div_"+user_id).css("display", "none");
        $("#"+field_name+"_field_div_"+user_id).css("display", "block");
    }
    
    function cancel_field_div(field_name, user_id)
    {
        $("#"+field_name+"_label_div_"+user_id).css("display", "block");
        $("#"+field_name+"_field_div_"+user_id).css("display", "none");
    }
    
    function save_field(field_name, user_id)
    {
        var field_value = $("#"+field_name+"_field_"+user_id).val();
        var values = "var values = {'user_id': '" + user_id + "', '" + field_name + "': '" + field_value + "'};";
        eval(values);
        $.ajax({
            url: '../ajax/Auth_ajax/SaveUser',
            type: 'POST',
            data: values,
            dataType: 'json',
            async: false,
            success: function(result){
                console.log(result);
                if (result.response !== false ) {
                    $("#"+field_name+"_label_"+user_id).html(field_value);
                    $("#"+field_name+"_label_"+user_id).attr("class", "link_normal");
                    $("#"+field_name+"_label_div_"+user_id).css("display", "block");
                    $("#"+field_name+"_field_div_"+user_id).css("display", "none");
                } else {
                    alert('Failed to save');
                }
            }
        });
        
    }
    
    function activate_user(user_id)
    {
        $.ajax({
            url: '../ajax/Auth_ajax/ActivateInactivateUser',
            type: 'POST',
            data: {'user_id': user_id, 'active': 1},
            dataType: 'json',
            async: false,
            success: function(result){
                console.log(result);
                if (result.response !== false ) {
                    $("#active_label_"+user_id).css("display", "block");
                    $("#inactive_label_"+user_id).css("display", "none");
                } else {
                    alert('Failed to activate');
                }
            }
        });
    }
    
    function inactivate_user(user_id)
    {
        $.ajax({
            url: '../ajax/Auth_ajax/ActivateInactivateUser',
            type: 'POST',
            data: {'user_id': user_id, 'active': 0},
            dataType: 'json',
            async: false,
            success: function(result){
                console.log(result);
                if (result.response !== false ) {
                    $("#active_label_"+user_id).css("display", "none");
                    $("#inactive_label_"+user_id).css("display", "block");
                } else {
                    alert('Failed to inactivate');
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
                  <h4><?php echo lang('index_heading');?></h4>
                  <p><?php echo lang('index_subheading');?></p>
                  <div id="infoMessage"><?php echo $message;?></div>
              </div>
              <div class="table-fixedheader">

            <table style="width: 100%" class="table-striped table-condensed table-bordered table-hover">
                <tbody class="connectedSortable">
                    <tr>
                            <th><?php echo lang('index_fname_th');?></th>
                            <th><?php echo lang('index_lname_th');?></th>
                            <th><?php echo lang('index_email_th');?></th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th><?php echo lang('index_groups_th');?></th>
                            <th>Customers</th>
                            <th><?php echo lang('index_status_th');?></th>
<!--                            <th><?php echo lang('index_action_th');?></th>-->
                    </tr>
                    <?php 
                    foreach ($users as $user):
                        $thisIsAdmin = false;
                    ?>
                    <tr>
                        <td>
                            <div id="first_name_label_div_<?php echo $user->id;?>">
                                <a id="first_name_label_<?php echo $user->id;?>" class="<?php echo $user->first_name ? 'link_normal' : '';?>" href="javascript:void(0);" onclick="show_field_div('first_name', '<?php echo $user->id;?>')">
                                    <?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?>
                                </a>
                            </div>
                            <div id="first_name_field_div_<?php echo $user->id;?>" style="display: none;  float: left;">
                                <input type="text" id="first_name_field_<?php echo $user->id;?>" value="<?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?>" />
                                <div style="clear: both; float: right;">
                                    <a href="javascript:void(0);" onclick="save_field('first_name', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/save-icon.png'?>" /></a>
                                    <a href="javascript:void(0);" onclick="cancel_field_div('first_name', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/cancel-icon.png'?>" /></a>
                                </div>                                    
                            </div>
                        </td>
                        <td>
                            <div id="last_name_label_div_<?php echo $user->id;?>">
                                <a id="last_name_label_<?php echo $user->id;?>" class="<?php echo $user->last_name ? 'link_normal' : '';?>" href="javascript:void(0);" onclick="show_field_div('last_name', '<?php echo $user->id;?>')">
                                    <?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?>
                                </a>
                            </div>
                            <div id="last_name_field_div_<?php echo $user->id;?>" style="display: none;  float: left;">
                                <input type="text" id="last_name_field_<?php echo $user->id;?>" value="<?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?>" />
                                <div style="clear: both; float: right;">
                                    <a href="javascript:void(0);" onclick="save_field('last_name', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/save-icon.png'?>" /></a>
                                    <a href="javascript:void(0);" onclick="cancel_field_div('last_name', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/cancel-icon.png'?>" /></a>
                                </div>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                        <td>
                            <div id="phone_label_div_<?php echo $user->id;?>">
                                <a id="phone_label_<?php echo $user->id;?>"  class="<?php echo $user->phone ? 'link_normal' : '';?>" href="javascript:void(0);" onclick="show_field_div('phone', '<?php echo $user->id;?>')">
                                    <?php echo $user->phone ? htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8') : 'Add';?>
                                </a>
                            </div>
                            <div id="phone_field_div_<?php echo $user->id;?>" style="display: none;  float: left;">
                                <input type="text" id="phone_field_<?php echo $user->id;?>" value="<?php echo htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8');?>" />
                                <div style="clear: both; float: right;">
                                    <a href="javascript:void(0);" onclick="save_field('phone', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/save-icon.png'?>" /></a>
                                    <a href="javascript:void(0);" onclick="cancel_field_div('phone', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/cancel-icon.png'?>" /></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div id="company_label_div_<?php echo $user->id;?>">
                                <a id="company_label_<?php echo $user->id;?>"  class="<?php echo $user->company ? 'link_normal' : '';?>" href="javascript:void(0);" onclick="show_field_div('company', '<?php echo $user->id;?>')">
                                    <?php echo htmlspecialchars($user->company,ENT_QUOTES,'UTF-8');?>
                                </a>
                            </div>
                            <div id="company_field_div_<?php echo $user->id;?>" style="display: none;  float: left;">
                                <input type="text" id="company_field_<?php echo $user->id;?>" value="<?php echo htmlspecialchars($user->company,ENT_QUOTES,'UTF-8');?>" />
                                <div style="clear: both; float: right;">
                                    <a href="javascript:void(0);" onclick="save_field('company', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/save-icon.png'?>" /></a>
                                    <a href="javascript:void(0);" onclick="cancel_field_div('company', '<?php echo $user->id;?>')"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/cancel-icon.png'?>" /></a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php
                            if (!$thisIsAdmin):
                                $selectedArr = array();
                                $names = array();
                                foreach($user->groups as $currentGroup) {
                                    $selectedArr[] = $currentGroup->id;
                                    $names[] = $currentGroup->name;
                                }
                                $this_st = $st . ' id="group_select_' . $user->id . '"';
                                ?>

                                <?php if (!empty($names)): ?>
                                    <a class="link_normal" id="group_name_list_<?php echo $user->id;?>" href="javascript:void(0);" onclick="show_group_select_div('<?php echo $user->id;?>')"><?php echo implode('<br />', $names);?></a>
                                <?php else: ?>
                                    <a id="group_name_list_<?php echo $user->id;?>" href="javascript:void(0);" onclick="show_group_select_div('<?php echo $user->id;?>')">Add</a>
                                <?php endif;?>

                                <div id="group_select_div_<?php echo $user->id;?>" style="display: none;">
                                    <?php echo form_dropdown('groupID', $option_groups, $selectedArr, $this_st);?>
                                    <div style="clear: both; float: right;">
                                    <a href="javascript:void(0);" onclick="save_group('<?php echo $user->id;?>')" style="font-size: 14px;"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/save-icon.png'?>" /></a>&nbsp;
                                    <a href="javascript:void(0);" onclick="cancel_group_select_div('<?php echo $user->id;?>')" style="font-size: 14px;"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/cancel-icon.png'?>" /></a>
                                    </div>
                                </div>

                            <?php else: ?>        
                                 N/A   
                            <?php endif; ?> 
                                 
                                 
                                 
                        </td>
                        <td>

                            <?php
                            if (!$thisIsAdmin):
                                $selectedArr = array();
                                $names = array();
                                if (isset($userCustomerMap[$user->id])) {
                                    $selectedArr = $userCustomerMap[$user->id]['ids'];
                                    $names = $userCustomerMap[$user->id]['names'];
                                }
                                $this_st = $st . ' id="customer_select_' . $user->id . '"';
                                ?>

                                <?php if (!empty($names)): ?>
                                    <a class="link_normal" id="customer_name_list_<?php echo $user->id;?>" href="javascript:void(0);" onclick="show_select_div('<?php echo $user->id;?>')"><?php echo implode('<br />', $names);?></a>
                                <?php else: ?>
                                    <a class="" id="customer_name_list_<?php echo $user->id;?>" href="javascript:void(0);" onclick="show_select_div('<?php echo $user->id;?>')">Add</a>
                                <?php endif;?>

                                <div id="customer_select_div_<?php echo $user->id;?>" style="display: none;">
                                    <?php echo form_dropdown('custID', $option_customers, $selectedArr, $this_st);?>
                                    <div style="clear: both; float: right;">
                                    <a href="javascript:void(0);" onclick="save_customer('<?php echo $user->id;?>')" style="font-size: 14px;"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/save-icon.png'?>" /></a>&nbsp;
                                    <a href="javascript:void(0);" onclick="cancel_select_div('<?php echo $user->id;?>')" style="font-size: 14px;"><img class="save_cancel_img" src="<?php echo base_url(). 'assets/images/cancel-icon.png'?>" /></a>
                                    </div>
                                </div>

                            <?php else: ?>        
                                 N/A   
                            <?php endif; ?>        
                        </td>
                        <td>
                            <div id="active_label_<?php echo $user->id;?>" style="float: left; <?php echo $user->active ? "display: block" : "display: none"?>">
                                <a class="link_normal" href="javascript:void(0);" onclick="inactivate_user('<?php echo $user->id;?>')">
                                <?php echo lang('index_active_link');?>
                                </a>
                            </div>
                            <div id="inactive_label_<?php echo $user->id;?>" style="float: left; <?php echo $user->active ? "display: none" : "display: block"?>">
                                <a class="link_normal" href="javascript:void(0);" onclick="activate_user('<?php echo $user->id;?>')">
                                <?php echo lang('index_inactive_link');?>
                                </a>
                            </div>
                        </td>
<!--                        <td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>-->
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

                  </div>
            </div>
            
            <p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>
            
        </div>      
    </div>
</div>

