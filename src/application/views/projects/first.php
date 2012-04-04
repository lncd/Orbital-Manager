<div class="row-fluid">
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
		
		<p>At the moment you don't have access to any projects in Orbital. Fortunately, we're here to help you get started as quickly as possible! Just use the simple form below and click the button, and we'll get you a shiny new project environment to play in.</p>
		
		<h2>Create First Project</h2>
		<form method="post" action="{base_url}projects/create" class="well">
			<label for="project_name">Project Name</label>
			<input type="text" id="project_name" name="project_name" placeholder="My Research Project">
			<span class="help-inline">Give your project a name so you can find it again in future.</span>
			<label for="project_abstract">Project Description</label>
			<textarea id="project_abstract" name="project_abstract" rows="4" placeholder="This is a project which…"></textarea>
			<span class="help-inline">Briefly describe your project.</span>
			<button type="submit" class="btn btn-large btn-success">Create Project</button>
		</form>

	</div>
</div>