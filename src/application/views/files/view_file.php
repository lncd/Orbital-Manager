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
				<a href="{base_url}project/{file_project_id}">{file_project}</a> <span class="divider">/</span>
			</li>
			<li class="active">
				{file_name}
			</li>
		</ul>

		<div class="page-header">
			<h1>{file_name}</h1>
		</div>
		<div class = "well">
		Licence: {file_licence}<br>
		Extension: {file_extension}<br>
		Mime type: {file_mimetype}<br>
		Project: <a href="{base_url}project/{file_project_id}">{file_project}</a>
		</div>
		<a class="btn btn-large btn-primary" href="{base_url}file/{file_id}/download"><i class = "icon-ok icon-download icon-white"></i> Download</a>		
		
		<?php
		
		if (isset ($project_startdate) AND isset($project_enddate))
		{
		
		?>
		
		<div class = "well">
			<h2>Project Progress</h2>
			<div class="progress">
  				<div class="bar" style="width: {project_complete}%;">
  				</div>
  			</div>
  			<div class = "pull-left"><b>Project Start</b><br>{project_startdate_pretty}
			</div>
			<div class = "pull-right"><b>Project End</b><br>{project_enddate_pretty}
			</div>
			<div style = clear:both>
			</div>
		</div>
		
		<?php } ?>
	</div>
</div>

<hr>
