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

<div class="row">
	<div class="span6">
		<div class="well">
			<h2>Project Details</h2>
			<form method="post" action="{base_url}project/{project_id}/edit">
				<label for="project_name">Project Name</label>
				<input type="text" id="project_name" name="name" value="{project_name}">
				<label for="project_abstract">Project Description</label>
				<textarea id="project_abstract" name="abstract" rows="4">{project_abstract}</textarea>
				<button type="submit" class="btn btn-success">Save Details</button>
			</form>
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<h2>Project Members</h2>
				<form method="post" action="{base_url}project/{project_id}/edit">
					<label for="project_name">Members</label>
					{project_users}
					<tr><td>{user}<br>
					<input type="checkbox" name="permission[{user_email}][read]" value="read" checked="{permission_read}">Read<br>
					<input type="checkbox" name="permission[{user_email}][write]" value="write" checked="{permission_write}">Write<br>
					<input type="checkbox" name="permission[{user_email}][delete]" value="delete" checked="{permission_delete}">Delete<br>
					<input type="checkbox" name="permission[{user_email}][archivefiles_write]" value="archivefiles_write" checked="{permission_archivefiles_write}">Archive Files Write<br>
					<input type="checkbox" name="permission[{user_email}][archivefiles_read]" value="archivefiles_read" checked="{permission_archivefiles_write}">Archive Files Read<br>
					<input type="checkbox" name="permission[{user_email}][sharedworkspace_read]" value="sharedworkspace_read" checked="{permission_sharedworkspace_read}">Shared Workspace Read<br>
					<input type="checkbox" name="permission[{user_email}][dataset_create]" value="dataset_create" checked="{permission_dataset_create}">Dataset Create<br></td></tr>
					<button type="submit" name = "save_members_details" value = "save_members_details" class="btn btn-success">Save Members Details</button>
					{/project_users}
				</form>
		</div>
	</div>
</div>