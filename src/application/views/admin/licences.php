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
			echo '<a href="#licence-' . $licence->id . '-disable" class="btn btn-warning" data-toggle="modal"><i class="icon-off icon-white"></i> Disable</a>
				<div class="modal fade" id="licence-' . $licence->id . '-disable">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">×</button>
						<h3>Disable Licence</h3>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to disable ' . $licence->name . '? This will prevent data from being published under it, and will disable its availability to projects as a default licence, but will not remove it from any data already published.</p>
					</div>
					<div class="modal-footer">
						<a href="#" data-dismiss="modal" class="btn">Close</a>
						<a href="#" data-dismiss="modal" class="btn btn-warning">Disable Licence</a>
					</div>
				</div>';
		}
		else
		{
			echo '<a href="#licence-' . $licence->id . '-enable" class="btn btn-success" data-toggle="modal"><i class="icon-off icon-white"></i> Enable</a>
				<div class="modal fade" id="licence-' . $licence->id . '-enable">
					<div class="modal-header">
						<button class="close" data-dismiss="modal">×</button>
						<h3>Enable Licence</h3>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to enable ' . $licence->name . '? This will allow data to be published under this licence, as well as allow projects to select it as their default licence.</p>
						<p><strong>Please Note:</strong> Once a licence is in use by published data it cannot be deleted without first unpublishing the data.</p>
					</div>
					<div class="modal-footer">
						<a href="#" data-dismiss="modal" class="btn">Close</a>
						<a href="#" data-dismiss="modal" class="btn btn-success">Enable Licence</a>
					</div>
				</div>';
		}
				
		echo '</td><td>';
		
		if ($licence->in_use)
		{
			echo '<a href="#" class="btn btn-danger disabled undeletable" rel="popover" data-content="This licence is being used by published data or is a default licence for a project, and cannot be deleted." data-original-title="Licence In Use"><i class="icon-trash icon-white"></i> Delete</a>';
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

<script type="text/javascript">
 $('.undeletable').popover({placement:'left'});
</script>