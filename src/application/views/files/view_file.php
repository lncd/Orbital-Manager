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
		{file_title}
	</li>
</ul>

<div class="page-header">
	<h1>{file_title}</h1>
</div>
<div class = "well">
	<table class="table">
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
</div>
		
		
		
		<table class = "table table-bordered table-striped" id="users_table">
		<?php
		if (count($archive_file_sets) > 0)
		{
		?>
		<thead><tr><th>File set name</th></tr></thead>
		<tbody>
			<?php foreach($archive_file_sets as $archive_file_set)
			{
			echo '<tr><td>';
			if ($archive_file_set->file_set_visibility === 'public')
			{
				$priv_icon = 'open';
			}
			else
			{
				$priv_icon = 'close';
			}
				
			echo '<a href="' . base_url() . 'collection/' . $archive_file_set->file_set_id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $archive_file_set->file_set_name . ' '; ?></td></tr>

			<?php
			}

			?>
		</tbody><?php
	}
	else
	{
		echo '<p>This file is not part of any file set';
	}
	
	echo '</table>';
	
		

//Check for Edit permissions
if ($permission_write === TRUE)
{
	echo '<p>';
	
	echo '<a href="' . site_url('file/' . $file_id . '/edit') . '" class="btn btn-small"><i class="icon-pencil"></i> Edit</a>';
		
	
	// Check for Delete permissions
	if ($permission_delete === TRUE)
	{								
		echo ' <a href="#delete_file" data-toggle="modal" class="btn btn-small btn-danger"><i class="icon-trash"></i> Delete</a>';
	}
	
	echo '</p>';
}



echo '<div class="modal fade" id="delete_file">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>Delete File</h3>
			<h4>' . $file_name . '</h4>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete this file?</p>
		</div>
		<div class="modal-footer">
			<a href="#" data-dismiss="modal" class="btn">Close</a>
			<a href="' . site_url('file/' . $file_id . '/delete') . '" class="btn btn-danger"><i class="icon-trash"></i> Delete File</a>
		</div>
	</div>';


if ($file_downloadable)
{

	echo '<a class="btn btn-primary" href="{base_url}file/{file_id}/download"><i class = "icon-ok icon-download icon-white"></i> Download File</a>';

}
else
{
	echo '<p>This file isn\'t available for download right now, as it is being processed by Orbital. It should be available soon.</p>';
}

?>
