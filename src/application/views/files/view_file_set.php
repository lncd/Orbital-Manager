<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{file_set_project_id}">{file_set_project}</a> <span class="divider">/</span>
	</li>
	<li class="active">
		{file_set_title}
	</li>
</ul>

<div class="page-header">
	<h1>{file_set_title}</h1>
</div>
<div class = "well">
	<table class="table">
		<thead>
			<tr><th colspan="2">File Set Summary</th></tr>
		</thead>
		<tbody>
			<tr><td>File Set Name</td><td>{file_set_title}</td></tr>
			<tr><td>Research Project</td><td><a href="{base_url}project/{file_set_project_id}">{file_set_project}</a></td>
			<tr><td>Number of Files</td><td><?php echo count($archive_files); ?></td></tr>
			<tr><td>Size of dataset</td><td>?</td></tr>
			</tr>
		</tbody>
	</table>
</div>


	<table class = "table table-bordered table-striped" id="users_table">
		<thead><tr><th>File name</th><th>File size</th></tr></thead>
		<tbody>
			<?php foreach($archive_files as $archive_file)
			{
			echo '<tr><td>';
			if ($archive_file->visibility === 'public')
			{
				$priv_icon = 'open';
			}
			else
			{
				$priv_icon = 'close';
			}
				
					echo '<a href="' . base_url() . 'file/' . $archive_file->id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $archive_file->original_name . ' '; ?></td>
			<td></td></tr>

			<?php
			}
			?>
		</tbody>
	</table>


		
		{file_controls}
		<a class="btn btn-small" href="{uri}">{title}</a>
		{/file_controls}
