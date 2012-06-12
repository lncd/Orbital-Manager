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
		Datasets
	</li>
</ul>

<div class="page-header">
	<h1>{project_name} <small>Datasets</small></h1>
</div>

<?php

if (count($datasets) > 0)
{	
?>
		
<table class = "table table-bordered table-striped" id="users_table">
	<thead><tr><th>Dataset Name</th><th>Description</th></tr></thead>
	<tbody>
		<?php foreach($datasets as $dataset)
		{
		echo '<tr><td width="100">';
		if ($dataset->visibility === 'public')
		{
			$priv_icon = 'open';
		}
		else
		{
			$priv_icon = 'close';
		}
			
		echo '<a href="' . base_url() . 'dataset/' . $dataset->id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $dataset->name . ' '; ?></td>
		<td><?php echo $dataset->description?></td></tr>

		<?php
		}
		?>
	</tbody>
</table>

<?php
			
		
}
else
{
	echo '<p>This project doesn\'t currently have any dataset.</p>';
}

?>