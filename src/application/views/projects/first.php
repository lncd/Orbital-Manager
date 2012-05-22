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
	
		<div class="page-header">
			<h1>My Projects</h1>
		</div>
		
		<p>Welcome to Orbital. Please create your first Project.</p>
		
		<h2>Create First Project</h2>
		<form method="post" action="{base_url}projects/create" class="well">
			<label for="project_name">Project Name</label>
			<input type="text" id="project_name" name="name" placeholder="My Research Project" required>
			<span class="help-inline">Give your project a name so you can find it again in future.</span>
			<label for="project_abstract">Project Description</label>
			<textarea id="project_abstract" name="abstract" rows="4" placeholder="This is a project which…" required></textarea>
			<span class="help-inline">Briefly describe your project.</span>
			<button type="submit" class="btn btn-large btn-success">Create Project</button>
		</form>

	</div>
</div>