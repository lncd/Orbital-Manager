<div class="row">
	<div class="span12">

		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}project/{project_id}">{project_name}</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}project/{project_id}/edit">Edit</a>
			</li>
		</ul>

		<div class="page-header">
			<h1>{project_name} <small>Edit</small></h1>
		</div>

	</div>
</div>

		<div class="well">
			<h2>Project Details</h2>
			
			<?php echo form_open('project/{project_id}/edit', array('class' => 'form-horizontal'));
			
			$form_name = array(
				'name'			=> 'name',
				'id'			=> 'project_name',
				'placeholder'	=> 'Project Name',
				'value'			=> set_value('name', $project_name),
				'maxlength'		=> '200',
				'class'			=> 'span6'
			);
	
			echo '<div class="control-group">';
			echo form_label('Project Name', 'project_name', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_input($form_name);
			echo '</div></div>';
			
			$form_abstract = array(
				'name'			=> 'abstract',
				'id'			=> 'project_abstract',
				'placeholder'	=> 'A bit about this project...',
				'value'			=> set_value('abstract', $project_abstract),
				'rows'			=> '4',
				'class'			=> 'span6'
			);
	
			echo form_label('Project Description', 'project_abstract');
			echo form_textarea($form_abstract);
			
			$form_researchgroup = array(
				'name'			=> 'research_group',
				'id'			=> 'project_research_group',
				'placeholder'	=> 'Group Name',
				'value'			=> set_value('research_group', $project_research_group),
				'maxlength'		=> '64',
				'class'			=> 'span4'
			);
	
			echo form_label('Research Group', 'project_research_group');
			echo form_input($form_researchgroup);
			
			$form_startdate = array(
				'name'			=> 'start_date',
				'id'			=> 'project_start_date',
				'placeholder'	=> 'YYYY-MM-DD',
				'value'			=> set_value('start_date', $project_start_date),
				'maxlength'		=> '10',
				'class'			=> 'span2 datepicker'
			);
	
			echo form_label('Project Start Date', 'project_start_date');
			echo form_input($form_startdate);
			
			$form_enddate = array(
				'name'			=> 'end_date',
				'id'			=> 'project_end_date',
				'placeholder'	=> 'YYYY-MM-DD',
				'value'			=> set_value('end_date', $project_end_date),
				'maxlength'		=> '10',
				'class'			=> 'span2 datepicker'
			);
	
			echo form_label('Project End Date', 'project_end_date');
			echo form_input($form_enddate);
			
			
			?>
			
				<label for="project_default_licence">Default Licence</label>
				<select id="project_default_licence" name="default_licence">
				<?php foreach ($licences as $licence)
				{
					echo '<option value = "' . $licence->id . '" ';
					if ($licence->id === $project_default_licence)
					{
						echo 'selected';
					}
					echo '>' . $licence->name .'</option>';
				}?>
				</select>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>
				</div>
				
			<?php echo form_close(); ?>
		</div>
		<div class="well">
			<h2>Project Members</h2>
				<form method="post" action="{base_url}project/{project_id}/edit">
				<table class = "table table-bordered table-striped">
				<thead><tr><th>User</th><th>Read</th><th>Write</th><th>Delete</th><th>Manage Users</th><th>Archive Write</th><th>Archive Read</th><th>Access Workspace</th><th>Create Dataset</th><th>Options</th></tr></thead>
				<tbody>
					<?php foreach($project_users as $user)
					{ ?>
					<tr><td><?php echo $user['user']; ?></td>
					<td><input type="checkbox" name="permission[{user_email}][read]" value="read" <?php if($user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][write]" value="write" <?php if($user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][delete]" value="delete" <?php if($user['permissions']['permission_delete'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][manage_users]" value="manage_users" <?php if($user['permissions']['permission_manage_users'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][archivefiles_write]" value="archivefiles_write" <?php if($user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][archivefiles_read]" value="archivefiles_read" <?php if($user['permissions']['permission_archivefiles_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][sharedworkspace_read]" value="sharedworkspace_read" <?php if($user['permissions']['permission_sharedworkspace_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][dataset_create]" value="dataset_create" <?php if($user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
					<td><a href="#" class = "btn btn-danger disabled"><i class = "icon-remove icon-white"></i> Remove</a></td></tr>

					<?php
					}
					?>
					</tbody>
					</table>
					<button type="submit" name = "save_members_details" value = "save_members_details" class="btn btn-success disabled"><i class = "icon-check icon-white"></i> Save Members</button>

				</form>
</div>