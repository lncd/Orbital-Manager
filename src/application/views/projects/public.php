<div class="row">
	<div class="span12">
	
		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
			</li>
			<li class="active">
				Public
			</li>
		</ul>
	
		<h1>Public Projects</h1>

	</div>
</div>

<div class="row">
	<div class="span8">
		<table class="table table-striped table-bordered">
			<thead>
				<tr><th>Name</th><th>Research Group</th><th>Start</th><th>End</th></tr>
			</thead>
			<tbody>
				{projects}
				<tr><td><a href = "{project_uri}/public">{project_name}</a> <th>{research_group}</th><th>{project_startdate}</th><th>{project_enddate}</td></tr>
				{/projects}
			</tbody>
		</table>
	</div>
</div>