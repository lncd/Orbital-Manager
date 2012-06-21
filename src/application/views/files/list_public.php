<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{project_id}/public">{project_name}</a> <span class="divider">/</span>
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
				if ($archive_file->visibility === 'public')
				{
					$priv_icon = 'open';
										
					if ($archive_file->extension === 'zip')
					{
						$extension_icon = 'folder-close';
					}
					else if ($archive_file->extension === 'txt')
					{
						$extension_icon = 'align-left';
					}
					else if ($archive_file->extension === 'jpg' || $archive_file->extension === 'bmp' || $archive_file->extension === 'png')
					{
						$extension_icon = 'picture';
					}
					else if ($archive_file->extension === 'mov' || $archive_file->extension === 'mp4' || $archive_file->extension === 'wmv' || $archive_file->extension === 'avi' || $archive_file->extension === 'mkv')
					{
						$extension_icon = 'facetime-video';
					}
					else
					{
						$extension_icon = 'file';
					}
							
					echo '<a href="' . base_url() . 'file/' . $archive_file->id . '/public"><i class="icon-eye-' . $priv_icon . '"></i> <i class="icon-' . $extension_icon . '"></i> ' . $archive_file->title . ' '; ?></td>
					<td><?php echo byte_format($archive_file->size, 2) ?></td>
					<td><?php echo $archive_file->uploaded ?></td>
					<td><?php echo $archive_file->licence ?></td></tr>
		
					<?php
				}
			}
			?>
		</tbody>
	</table>


<?php
			
				
	}
	else
	{
		echo '<p>There are no archive files stored in this project.';
	}
	
	?>