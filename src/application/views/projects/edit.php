<div class="row-fluid">
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

		<h1>Edit: {project_name}</h1>

	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="well">
			<h2>Project Details</h2>
					<form method="post" action="{base_url}projects/create">
				<label for="project_name">Project Name</label>
				<input type="text" id="project_name" name="name" placeholder="My Research Project">
				<label for="project_abstract">Project Description</label>
				<textarea id="project_abstract" name="abstract" rows="4" placeholder="This is a project which…"></textarea>			</form>
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<h2>Project Members</h2>
						<form method="post" action="{base_url}projects/create">
				<label for="project_name">Members</label>
				{project_users}
				<tr><td>{user}<br><input type="checkbox" name="Read" value="read" checked="{permission_read}">Read<br></td></tr>
				{/project_users}		</form>
		</div>
	</div>
	<button type="submit" class="btn btn-success">Save Details</button>
</div>