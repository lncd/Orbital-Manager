<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}admin">Administration</a> <span class="divider">/</span>
	</li>
	<li class="active">
		Data Licences
	</li>
</ul>

<div class="page-header">
	<h1>Data Licences</h1>
</div>
		
<p>The following licences are available to users making data public in Orbital:</p>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Licence Name</th>
			<th>Short Name</th>
			<th>Edit</th>
			<th>Enable/Disable</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
	
	<?php
	
	foreach ($licences as $licence)
	{
		echo '<tr>
				<td>' . $licence->name . '</td>
				<td>' . $licence->short_name . '</td>
				<td><a href="#" class="btn"><i class="icon-pencil"></i> Edit</a></td>
				<td>';
				
		if ($licence->enabled)
		{
			echo '<a href="#" class="btn btn-warning"><i class="icon-off icon-white"></i> Disable</a>';
		}
		else
		{
			echo '<a href="#" class="btn btn-success"><i class="icon-off icon-white"></i> Enable</a>';
		}
				
		echo '</td><td>';
		
		if ($licence->in_use)
		{
			echo '<a href="#" class="btn btn-danger disabled"><i class="icon-trash icon-white"></i> Delete</a>';
		}
		else
		{
			echo '<a href="#" class="btn btn-danger"><i class="icon-trash icon-white"></i> Delete</a>';
		}
		
		echo '</td>
			</tr>';
	}
	
	?>
	
	</tbody>
</table>

<p><a href="#" class="btn btn-success disabled"><i class="icon-plus icon-white"></i> Add Licence</a>