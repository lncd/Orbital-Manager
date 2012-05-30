<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{project_id}">{project_name}</a> <span class="divider">/</span>
	</li>
	<li class="active">
		Files
	</li>
</ul>

<div class="page-header">
	<h1>{project_name}</h1>
</div>

	<?php
	
	if (count($archive_files) > 0)
	{	
	?>
			
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
				
					echo '<li><a href="' . base_url() . 'file/' . $archive_file->id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $archive_file->original_name . ' '; ?></td>
			<td></td></tr>

			<?php
			}
			?>
		</tbody>
	</table>


<?php
			
				
	}
	else
	{
		echo '<p>You don\'t have any archive files stored in this project.</p>
		<p>Archive your files to permanently store and publish your data.';
	}
	
	?>