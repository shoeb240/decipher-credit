<h1><?php echo lang('assign_users_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/assign_users");?>
	<?php 
		$option_users = array();
		$option_customers = array();
	?>
	<?php
		foreach($users as $user):
			$option_users[] = array(
				$user['id'] => $user['first_name']." ".$user['last_name'] 
			);
		endforeach;

		foreach($customers as $customer):
			$option_customers[] = array(
				$customer['id'] => $customer['nameLast'] 
			);
		endforeach;
	?>
      <p>
            <?php echo lang('assign_user_userid_label', 'user_id');?> <br />
            <?php echo form_dropdown('userID', $option_users, 'userID');?>
      </p>

      <p>
            <?php echo lang('assign_user_custid_label', 'cust_id');?> <br />
            <?php echo form_dropdown('custID', $option_customers, 'customerID');?>
      </p>

      <p><?php echo form_submit('submit', lang('assign_users_submit_btn'));?></p>

<?php echo form_close();?>
