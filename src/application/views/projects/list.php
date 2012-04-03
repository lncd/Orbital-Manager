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
		
		<table class="table table-striped table-bordered">
			<thead>
				<tr><th>Name</th></tr>
			</thead>
			<tbody>
				{projects}
				<tr><td><a href = "{project_uri}">{project_name}</a></td></tr>
				{/projects}
			</tbody>
		</table>
		
	</div>
</div>