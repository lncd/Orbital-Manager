<div class="row-fluid">
	<div class="span12">

		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}project/{project_id}">{project_name}</a></span>
			</li>
		</ul>

		<h1>{project_name}</h1>
		{project_description}
		
		<div class = "well">
			<h2>Project Progress</h2>
			<div class="progress">
  				<div class="bar" style="width: {project_complete}%;">
  				</div>
  			</div>
			<div class = "container-fluid">
				<div class = "row-fluid">
					<div class = "span6"><b>Project Start</b><br>{project_startdate_pretty}
					</div>
					<div class = "span6" style = "text-align:right"><b>Project End</b><br>{project_enddate_pretty}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<div class="well">
			<h2>Workspace</h2>
		</div>
	</div>
	<div class="span4">
		<div class="well">
			<h2>Working Data</h2>
		</div>
	</div>
	<div class="span4">
		<div class="well">
			<h2>File Archives</h2>
		</div>
	</div>
</div>