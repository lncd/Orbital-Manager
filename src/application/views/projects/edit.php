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

<div class="well">
	<h2>Project Details</h2>
	
	<?php echo form_open('project/{project_id}/edit', array('class' => 'form-horizontal'));
	
	$form_name = array(
		'name'			=> 'name',
		'required'    => 'required',
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
		'required'    => 'required',
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
	echo form_label('Publish This Project', 'project_public', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_checkbox($form_public);
	echo '<p class="help-block">This creates a public web page for your project which people can cite. If you upload public datasets they will be available to download from this page.</p>';
	echo '</div></div>';
	
	if (isset($licences) AND count($licences) > 0)
	{
		foreach ($licences as $licence)
		{
			$available_licences[$licence->id] = $licence->name;
		}

	echo '<div class="control-group">';
	echo form_label('Default Licence', 'project_default_licence', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $project_default_licence), 'id="project_default_licence" class="span4"');
	echo '<p class="help-block">Choosing a default licence makes it easier to publish and share your data. However, you can still change it on a case-by-case basis for individual files and datasets.</p>';
	echo '
	<br>
	<div class="well" style="background:#FDFDFD">
	
		<div id="licenceAllow" style="display:none">
			<h4>This licence allows:</h4>
			<div id="licenceAllowContent">
			</div>
		</div>
		
		<div id="licenceDeny" style="display:none">
			<h4>This licence forbids:</h4>
			<div id="licenceDenyContent">
			</div>
		</div>
		
		<div id="licenceConditions" style="display:none">
			<h4>This licence has the following conditions:</h4>
			<div id="licenceConditionsContent">
			</div>
		</div>
		
		<h4>Read More</h4>
		<p>More information about this licence, including legal text, is available at:<br>
		<span id="licenceInfoURL"><a href="' . $licence->uri . '" target="_blank">' . $licence->uri . ' <i class="icon-external-link"></i></a></span></p>
	</div>
</div>
</div>';
	}
	else
	{	
		$available_licences[$project_default_licence] = $project_default_licence_name;
		
		echo '<div class="control-group">';
		echo form_label('Default Licence', 'project_default_licence', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $project_default_licence), 'id="project_default_licence" class="span4"');
		echo '<p class="help-block">Choosing a default licence makes it easier to publish and share your data. However, you can still change it on a case-by-case basis for individual files and datasets.</p>';
		echo '
		<br>
		<div class="well" style="background:#FDFDFD">
		
			<div id="licenceAllow" style="display:none">
				<h4>This licence allows:</h4>
				<div id="licenceAllowContent">
				</div>
			</div>
			
			<div id="licenceDeny" style="display:none">
				<h4>This licence forbids:</h4>
				<div id="licenceDenyContent">
				</div>
			</div>
			
			<div id="licenceConditions" style="display:none">
				<h4>This licence has the following conditions:</h4>
				<div id="licenceConditionsContent">
				</div>
			</div>
			
			<h4>NO LICENCES ARE ENABLED</h4>
			<p>Only the licence this project currently has can be selected</p>
		</div>
	</div>
	</div>';
	}
echo'
<div class="control-group">
<div class="controls">
<h4><a onClick="$(\'#projectAdvancedSettings\').toggle(\'blind\');"><i class="icon-cog"></i> Show/Hide Advanced Settings</a></h4>
</div>
</div>

<div id="projectAdvancedSettings" style="display:none">';
	
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
	echo '<p class="help-block">If you want to track how many people view your project and download files you can enter a <a href="http://www.google.com/analytics/">Google Analytics</a> property ID here.</p><br>';
	echo 'To set up Google Analytics, visit the <a href="http://www.google.com/analytics/">Google Analytics</a> site and sign in. It will walk you through the setup and provide you with an ID you can use here for monitoring the project. If you do not have an account, one can be setup for free.';

	echo '</div></div>';
		
	// Close advanced settings div
	echo '</div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button> <button type="reset" class="btn btn-warning">Reset</button>';
	echo '</div>';
		
	echo form_close(); ?>
</div>

<script>
	$(document).ready(function() {
		$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
	});
</script>

<div class="well">
	<h2>Project Members</h2>
	
		<!-- EDIT MEMBERS -->
	
		<form method="post" action="{base_url}project/{project_id}/edit">
		<table class = "table table-bordered table-striped" id="users_table">
		<thead><tr><th>User</th><th>Read</th><th>Write</th><th>Delete</th><th>Manage Users</th><th>Archive Write</th><th>Archive Read</th><th>Access Workspace</th><th>Create Dataset</th><th>Remove User?</th></tr></thead>
		<tbody>
			<?php foreach($project_users as $project_user)
			{
			if ($project_user['user'] === $this->session->userdata('current_user_string'))
			{
			?>
			<tr><td><?php echo $project_user['user']; ?> <span class="label">You</span></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][read]" value="TRUE" <?php if($project_user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][write]" value="TRUE" <?php if($project_user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][delete]" value="TRUE" <?php if($project_user['permissions']['permission_delete'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][manage_users]" value="TRUE" <?php if($project_user['permissions']['permission_manage_users'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][archivefiles_write]" value="TRUE" <?php if($project_user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][archivefiles_read]" value="TRUE" <?php if($project_user['permissions']['permission_archivefiles_read'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][sharedworkspace_read]" value="TRUE" <?php if($project_user['permissions']['permission_sharedworkspace_read'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" disabled name="permission[<?php echo $project_user['user'];?>][dataset_create]" value="TRUE" <?php if($project_user['permissions']['permission_dataset_create'] === TRUE){echo 'checked';} ?>></td>
			<td></td></tr>

			<?php
			}
			else
			{
			?>
			<tr><td><?php echo $project_user['user']; ?></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][read]" value="TRUE" <?php if($project_user['permissions']['permission_read'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][write]" value="TRUE" <?php if($project_user['permissions']['permission_write'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][delete]" value="TRUE" <?php if($project_user['permissions']['permission_delete'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][manage_users]" value="TRUE" <?php if($project_user['permissions']['permission_manage_users'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][archivefiles_write]" value="TRUE" <?php if($project_user['permissions']['permission_archivefiles_write'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][archivefiles_read]" value="TRUE" <?php if($project_user['permissions']['permission_archivefiles_read'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][sharedworkspace_read]" value="TRUE" <?php if($project_user['permissions']['permission_sharedworkspace_read'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][dataset_create]" value="TRUE" <?php if($project_user['permissions']['permission_dataset_create'] === TRUE){echo 'checked';} ?>></td>
			<td><input type="checkbox" name="permission[<?php echo $project_user['user'];?>][remove]" value="TRUE"></td></tr>

			<?php
			}
			}
			?>
			</tbody>
			</table>
			<button type="submit" name = "save_members_details" value = "save_members_details" class="btn btn-success"><i class = "icon-check icon-white"></i> Save Members</button> <a class="btn" data-toggle="modal" href="#addMember" ><i class = "icon-plus"></i> Add new member</a>

		</form>
		
		<!-- ADD MEMBER -->

		<form class="modal fade" id="addMember">
			<div class="modal-header">
				<button class="close" data-dismiss="modal">×</button>
				<h3>Add Member</h3>
			</div>
			<div class="modal-body">
				<input type="text" id = "user_email" size="12" maxlength="255" name="user">
			</div>
			<div class="modal-footer">
				<a name = "add_members_details" id = "add_member" value = "add_members_details" class="btn btn-success"><i class = "icon-plus"></i> Add Member</a>
			</div>
		</form>
		
</div>

<script type="text/javascript">

	$('#add_member').click(function()
	{
		user_email = $('#user_email').val();
		$('#users_table').append('<tr><td>' + user_email + ' <span class="label label-success">New</span></td><td><input type="checkbox" name="permission[' + user_email + '][read]" value="TRUE" checked></td>	<td><input type="checkbox" name="permission[' + user_email + '][write]" value="TRUE"></td><td><input type="checkbox" name="permission[' + user_email + '][delete]" value="TRUE"></td><td><input type="checkbox" name="permission[' + user_email + '][manage_users]" value="TRUE"></td><td><input type="checkbox" name="permission[' + user_email + '][archivefiles_write]" value="TRUE"></td><td><input type="checkbox" name="permission[' + user_email + '][archivefiles_read]" value="TRUE" checked></td><td><input type="checkbox" name="permission[' + user_email + '][sharedworkspace_read]" value="TRUE"></td><td><input type="checkbox" name="permission[' + user_email + '][dataset_create]" value="TRUE"></td><td><input type="checkbox" name="permission[' + user_email + '][remove]" value="TRUE"></td></tr>');
		$('#addMember').modal('hide');

	});

	$.getJSON('{base_url}licence/' + $('#project_default_licence').val() + '/json', function(data) {
	
		if (data.allow !== null)
		{
			$('#licenceAllowContent').html(data.allow);
			$('#licenceAllow').show();
		}
		
		if (data.conditions !== null)
		{
			$('#licenceConditionsContent').html(data.conditions);
			$('#licenceConditions').show();
		}
		
		if (data.forbid !== null)
		{
			$('#licenceDenyContent').html(data.forbid);
			$('#licenceDeny').show();
		}
		
		$('#licenceInfoURL').html('<a href="' + data.summary_uri + '" target="_blank">' + data.summary_uri + ' <i class="icon-external-link"></i></a>');
	  
	});
	
	$('#project_default_licence').change(function(){
	
			
		$.getJSON('{base_url}licence/' + $('#project_default_licence').val() + '/json', function(data) {
		  
			if (data.allow !== null)
			{
				$('#licenceAllowContent').html(data.allow);
				$('#licenceAllow').show();
			}
			else
			{
				$('#licenceAllow').hide();
			}
			
			if (data.conditions !== null)
			{
				$('#licenceConditionsContent').html(data.conditions);
				$('#licenceConditions').show();
			}
			else
			{
				$('#licenceConditions').hide();
			}
			
			if (data.forbid !== null)
			{
				$('#licenceDenyContent').html(data.forbid);
				$('#licenceDeny').show();
			}
			else
			{
				$('#licenceDeny').hide();
			}
			
			$('#licenceInfoURL').html('<a href="' + data.summary_uri + '" target="_blank">' + data.summary_uri + ' <i class="icon-external-link"></i></a>');
		  
		});
	  
	});

</script>