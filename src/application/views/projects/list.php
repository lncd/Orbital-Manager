<div class="row">
	<div class="span12">
	
		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}projects">Projects</a></span>
			</li>
		</ul>
	
		<h1>My Projects</h1>

	</div>
</div>

<div class="row">
	<div class="span8">
		<table class="table table-striped table-bordered">
			<thead>
				<tr><th>Name</th><th>Start</th><th>End</th></tr>
			</thead>
			<tbody>
				{projects}
				<tr><td><a href = "{project_uri}">{project_name}</a> <th>{project_startdate}</th><th>{project_enddate}</th></td></tr>
				{/projects}
			</tbody>
		</table>
	</div>
	<div class="span4">
		<div class="well">
			<h2>Create A Project</h2>
			<form method="post" action="{base_url}projects/create">
				<label for="project_name">Project Name</label>
				<input type="text" id="project_name" name="name" placeholder="My Research Project" required>
				<label for="project_abstract">Project Description</label>
				<textarea id="project_abstract" name="abstract" rows="4" placeholder="This is a project which…" required></textarea>
				<button type="submit" class="btn btn-success">Create Project</button>
			</form>

		</div>
	</div>
</div>