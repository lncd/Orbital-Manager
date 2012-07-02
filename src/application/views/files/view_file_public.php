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
		{file_title}
	</li>
</ul>
<div class="page-header">
	<h1>
	
	<?php
	
	if (file_exists('img/icons/48/' . $file_extension . '.png'))
	{
		$extension_icon = 'img/icons/48/' . $file_extension . '.png';
	}
	else
	{
		$extension_icon = 'img/icons/48/_blank.png';
	}

	echo '<img src="' . base_url() . $extension_icon . '">';

	?>
	
	{file_title}</h1>
</div>
	<table class="table table-bordered">
		<thead>
			<tr><th colspan="2">File Summary</th></tr>
		</thead>
		<tbody>
			<tr><td>Original File Name</td><td>{file_name}</td></tr>
			<tr><td>File Size</td><td><?php echo byte_format($file_size) ?></td></tr>
			<tr><td>Licence</td><td><a href="{file_licence_uri}">{file_licence}</a></td></tr>
			<tr><td>Research Project</td><td><a href="{base_url}project/{file_project_id}">{file_project}</a></td></tr>
			<tr><td>Permanent URI</td><td><code>http://id.lincoln.ac.uk/research-file/{file_id}</code></td></tr>
		</tbody>
	</table>
<?php

if (isset ($file_downloadable))
{
	if($file_downloadable)
	{
		echo '<a class="btn btn-primary" href="{base_url}file/{file_id}/download" onClick="recordDownload(this, \'{file_id}\');"><i class = "icon-ok icon-download icon-white"></i> Download File</a>';
	}
	else if ($file_downloadable === 'no')
	{
		echo '<p>This file isn\'t available for download.</p>';
	}
}
else
{
	echo '<p>This file isn\'t available for download right now, as it is being processed by Orbital. It should be available soon.</p>';
}

?>