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
		File Archives
	</li>
</ul>

<div class="page-header">
	<h1>{project_name} <small>File Archives</small></h1>
</div>

	<?php
	
	if (count($archive_files) > 0)
	{	
	?>
			
	<table class = "table table-bordered table-striped" id="users_table">
		<thead><tr><th>File name</th><th>File size</th><th>Uploaded</th><th>Licence</th></tr></thead>
		<tbody>
			<?php foreach($archive_files as $archive_file)
			{
			echo '<tr><td>';
			if ($archive_file->visibility === 'public' OR $archive_file->visibility === 'visible')
			{
				$priv_icon = 'open';
			}
			else
			{
				$priv_icon = 'close';
			}
			if (file_exists('img/icons/16/' . $archive_file->extension . '.png'))
			{
				$extension_icon = 'img/icons/16/' . $archive_file->extension . '.png';
			}
			else
			{
				$extension_icon = 'img/icons/16/_blank.png';
			}
				
			echo '<a href="' . base_url() . 'file/' . $archive_file->id . '"><i class="icon-eye-' . $priv_icon . '"></i> <img src="' . base_url() . $extension_icon . '"> ' . $archive_file->title . ' '; ?></td>
			<td><?php echo byte_format($archive_file->size, 2) ?></td>
			<td><?php echo $archive_file->uploaded ?></td>
			<td><?php echo $archive_file->licence ?></td></tr>

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