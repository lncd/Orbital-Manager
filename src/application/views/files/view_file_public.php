<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects/public">Public Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{file_project_id}/public">{file_project}</a> <span class="divider">/</span>
	</li>
	<li class="active">
		{file_name}
	</li>
</ul>

<div class="page-header">
	<h1>{file_name}</h1>
</div>
<div class = "well">
	<table class="table">
		<thead>
			<tr><th colspan="2">File Summary</th></tr>
		</thead>
		<tbody>
			<tr><td>Licence</td><td><a href="{file_licence_uri}">{file_licence}</a></td></tr>
			<tr><td>Research Project</td><td><a href="{base_url}project/{file_project_id}/public">{file_project}</a></td></tr>
			<tr><td>Permanent URI</td><td><code>http://id.lincoln.ac.uk/research-file/{file_id}/public</code></td></tr>
		</tbody>
	</table>
</div>

<?php

if ($file_downloadable)
{

	echo '<a class="btn btn-primary" href="{base_url}file/{file_id}/download"><i class = "icon-ok icon-download icon-white"></i> Download File</a>';

}
else
{
	echo '<p>This file isn\'t available for download right now, as it is being processed by Orbital. It should be available soon.</p>';
}

?>	
