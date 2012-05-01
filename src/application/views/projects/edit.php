<head>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  
  <script>
  $(document).ready(function() {
    $(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
  });
  </script>
</head>
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
				'rows'			=> '5',
				'class'			=> 'span6'
			);
	
			echo '<div class="control-group">';
			echo form_label('Project Description', 'project_abstract', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_textarea($form_abstract);
			echo '</div></div>';
			
			$form_researchgroup = array(
				'name'			=> 'research_group',
				'id'			=> 'project_research_group',
				'placeholder'	=> 'Group Name',
				'value'			=> set_value('research_group', $project_research_group),
				'maxlength'		=> '64',
				'class'			=> 'span4'
			);
	
			echo '<div class="control-group">';
			echo form_label('Research Group', 'project_research_group', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_input($form_researchgroup);
			echo '</div></div>';
			
			$form_startdate = array(
				'name'			=> 'start_date',
				'id'			=> 'project_start_date',
				'placeholder'	=> 'YYYY-MM-DD',
				'value'			=> set_value('start_date', $project_start_date),
				'maxlength'		=> '10',
				'class'			=> 'span2 datepicker'
			);
	
			echo '<div class="control-group">';
			echo form_label('Project Start Date', 'project_start_date', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_input($form_startdate);
			echo '</div></div>';
			
			$form_enddate = array(
				'name'			=> 'end_date',
				'id'			=> 'project_end_date',
				'placeholder'	=> 'YYYY-MM-DD',
				'value'			=> set_value('end_date', $project_end_date),
				'maxlength'		=> '10',
				'class'			=> 'span2 datepicker'
			);
	
			echo '<div class="control-group">';
			echo form_label('Project End Date', 'project_end_date', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_input($form_enddate);
			echo '</div></div>';
			
			$form_public = array(
				'name'		=> 'public',
				'id'		=> 'project_public',
				'value'		=> 'public',
				'checked'	=> set_checkbox('public', 'public', $project_public_view)
			);
	
			echo '<div class="control-group">';
			echo form_label('Show Public View', 'project_public', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_checkbox($form_public);
			echo '<p class="help-block">If you enable the public view then there will be a summary of this project as well as a list of its publicly available dynamic datasets and archived files made available for general viewing.</p>';
			echo '</div></div>';
			
			foreach ($licences as $licence)
			{
				$available_licences[$licence->id] = $licence->name;
			}
	
			echo '<div class="control-group">';
			echo form_label('Default Licence', 'project_default_licence', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $project_default_licence), 'id="project_default_licence" class="span4"');
			echo '<p class="help-block">Choosing a default licence makes it easier to publish your data. However, you can still change it on a case-by-case basis for individual files and datasets.</p>';
			echo '</div></div>';
			
			$form_ga = array(
				'name'			=> 'google_analytics',
				'id'			=> 'project_google_analytics',
				'placeholder'	=> 'UA-XXXXXXXX-X',
				'value'			=> set_value('google_analytics', $project_google_analytics),
				'class'			=> 'span3'
			);
	
			echo '<div class="control-group">';
			echo form_label('Google Analytics Property ID', 'project_google_analytics', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo form_input($form_ga);
			echo '<p class="help-block">If you want to track how many people view your project and download files you can enter a <a href="http://www.google.com/analytics/">Google Analytics</a> property ID here.</p>';
			echo '</div></div>';

			echo '<div class="form-actions">';
			echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button> <button type="reset" class="btn btn-warning">Reset</button>';
			echo '</div>';
				
			echo form_close(); ?>
		</div>
		<div class="well">
			<h2>Project Members</h2>
				<form method="post" action="{base_url}project/{project_id}/edit">
				<table class = "table table-bordered table-striped">
				<thead><tr><th>User</th><th>Read</th><th>Write</th><th>Delete</th><th>Manage Users</th><th>Archive Write</th><th>Archive Read</th><th>Access Workspace</th><th>Create Dataset</th><th>Options</th></tr></thead>
				<tbody>
					<?php foreach($project_users as $project_user)
					{
					if ($project_user['user'] === $this->session->userdata('current_user_string'))
					{
					?>
					<tr><td><?php echo $project_user['user']; ?></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][read]" value="read" <?php if($project_user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][write]" value="write" <?php if($project_user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][delete]" value="delete" <?php if($project_user['permissions']['permission_delete'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][manage_users]" value="manage_users" <?php if($project_user['permissions']['permission_manage_users'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][archivefiles_write]" value="archivefiles_write" <?php if($project_user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][archivefiles_read]" value="archivefiles_read" <?php if($project_user['permissions']['permission_archivefiles_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][sharedworkspace_read]" value="sharedworkspace_read" <?php if($project_user['permissions']['permission_sharedworkspace_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" disabled name="permission[{user_email}][dataset_create]" value="dataset_create" <?php if($project_user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
					<td></td></tr>

					<?php
					}
					else
					{
					?>
					<tr><td><?php echo $project_user['user']; ?></td>
					<td><input type="checkbox" name="permission[{user_email}][read]" value="read" <?php if($project_user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][write]" value="write" <?php if($project_user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][delete]" value="delete" <?php if($project_user['permissions']['permission_delete'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][manage_users]" value="manage_users" <?php if($project_user['permissions']['permission_manage_users'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][archivefiles_write]" value="archivefiles_write" <?php if($project_user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][archivefiles_read]" value="archivefiles_read" <?php if($project_user['permissions']['permission_archivefiles_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][sharedworkspace_read]" value="sharedworkspace_read" <?php if($project_user['permissions']['permission_sharedworkspace_read'] === TRUE){echo 'checked';} ?>></td>
					<td><input type="checkbox" name="permission[{user_email}][dataset_create]" value="dataset_create" <?php if($project_user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
					<td><a href="#" class = "btn btn-danger disabled"><i class = "icon-remove icon-white"></i> Remove</a></td></tr>

					<?php
					}
					}
					?>
					</tbody>
					</table>
					<button type="submit" name = "save_members_details" value = "save_members_details" class="btn btn-success disabled"><i class = "icon-check icon-white"></i> Save Members</button>

				</form>
</div>