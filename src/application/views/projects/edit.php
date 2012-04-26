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
			<form method="post" action="{base_url}project/{project_id}/edit">
				<label for="project_name">Project Name</label>
				<input type="text" id="project_name" name="name" value="{project_name}">
				<label for="project_abstract">Project Description</label>
				<textarea id="project_abstract" name="abstract" rows="4">{project_abstract}</textarea>
				<label for="project_research_group">Research Group</label>
				<input type="text" id="project_research_group" name="research_group" value="{project_research_group}">
				<label for="project_start_date">Start Date</label>
				<input type="date" id="project_start_date" name="start_date" value="{project_start_date}">
				<label for="project_end_date">End Date</label>
				<input type="text" id="project_end_date" name="end_date" value="{project_end_date}">
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
				<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>
			</form>
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