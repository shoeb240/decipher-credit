<h1><?php echo 'All Groups';?></h1>

<table cellpadding=0 cellspacing=10>
	<tr>
		<th><?php echo 'Group ID';?></th>
		<th><?php echo 'Group Name';?></th>
		<th><?php echo 'Group Link';?></th>
                
	</tr>
	<?php foreach ($groups as $group):?>
		<tr>
            <td><?php echo htmlspecialchars($group->id,ENT_QUOTES,'UTF-8');?></td>
            <td><?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?></td>
   			<td>
					<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
			</td>
		</tr>
	<?php endforeach;?>
</table>

<p>
    <?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>