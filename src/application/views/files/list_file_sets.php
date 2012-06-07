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
		File Collections
	</li>
</ul>

<div class="page-header">
	<h1>{project_name} <small>File Collections</small></h1>
</div>

<?php

if (count($file_sets) > 0)
{	
?>
		
<table class = "table table-bordered table-striped" id="users_table">
	<thead><tr><th>Set Name</th><th>No. Files</th><th>Description</th></tr></thead>
	<tbody>
		<?php foreach($file_sets as $file_set)
		{
		echo '<tr><td width="100">';
		if ($file_set->file_set_visibility === 'public')
		{
			$priv_icon = 'open';
		}
		else
		{
			$priv_icon = 'close';
		}
			
		echo '<a href="' . base_url() . 'collection/' . $file_set->file_set_id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $file_set->file_set_name . ' '; ?></td>
		<td>????????</td>
		<td><?php echo $file_set->file_set_description?></td></tr>

		<?php
		}
		?>
	</tbody>
</table>

<?php
			
		
}
else
{
	echo '<p>This project doesn\'t currently have any file collections.</p>';
}

?>