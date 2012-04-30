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
						<a href="' . site_url('admin/licence/' . $licence->id . '/disable') . '" class="btn btn-warning"><i class="icon-off icon-white"></i> Disable Licence</a>
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
						<a href="' . site_url('admin/licence/' . $licence->id . '/enable') . '" class="btn btn-success"><i class="icon-off icon-white"></i> Enable Licence</a>
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

<p><a href="#addLicenceDialog" class="btn btn-success" data-toggle="modal"><i class="icon-plus icon-white"></i> Add Licence</a></p>


<?php

echo form_open(site_url('admin/licences/add'), array(
	'class' => 'modal fade',
	'id' => 'addLicenceDialog'
));

?>

	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>Add Licence</h3>
	</div>
	<div class="modal-body">
		
		<?php
		
		$form_name = array(
			'name'        => 'name',
			'id'          => 'name',
			'placeholder' => 'Orbital Example Licence',
			'maxlength'   => '255'
		);

		echo form_label('Full name of the licence', 'name');
		echo form_input($form_name);
		
		$form_shortname = array(
			'name'        => 'shortname',
			'id'          => 'shortname',
			'placeholder' => 'OEL v1.0',
			'maxlength'   => '16'
		);

		echo form_label('Short name of the licence', 'shortname');
		echo form_input($form_shortname);
		
		$form_url = array(
			'name'        => 'url',
			'id'          => 'url',
			'placeholder' => 'http://example.com/licence/summary',
			'maxlength'   => '255'
		);

		echo form_label('URL of the licence summary', 'url');
		echo form_input($form_url);
		
		?>
		
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i> Add Licence</button>
	</div>
  
<?php echo form_close(); ?>

<script type="text/javascript">
	$('.undeletable').popover({placement:'left'});
</script>