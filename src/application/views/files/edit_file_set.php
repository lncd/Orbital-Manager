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
	<li>
		<a href="{base_url}collection/{file_set_id}">{file_set_title}</a> <span class="divider">/</span>
	</li>
	<li class="active">
		Edit
	</li>
</ul>

<div class="page-header">
	<h1>{file_set_title} <small>Edit</small></h1>
</div>

<div class="well">
	<h2>File Collection Details</h2>
	<br>
	
	<?php echo form_open('collection/{file_set_id}/edit', array('class' => 'form-horizontal'));
	
	$form_name = array(
		'name'			=> 'file_set_name',
		'id'			=> 'file_set_name',
		'placeholder'	=> 'Collection Name',
		'value'			=> set_value('name', $file_set_title),
		'maxlength'		=> '200',
		'class'			=> 'span6'
	);

	echo '<div class="control-group">';
	echo form_label('Collection Name', 'collection_name', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_name);
	echo '</div></div>';
	
	$form_abstract = array(
		'name'			=> 'file_set_description',
		'id'			=> 'file_set_description',
		'placeholder'	=> 'A bit about this collection...',
		'value'			=> set_value('abstract', $file_set_description),
		'rows'			=> '5',
		'class'			=> 'span6'
	);

	echo '<div class="control-group">';
	echo form_label('Collection Description', 'collection_description', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_textarea($form_abstract);
	echo '</div></div>';
	
	echo '<table class = "table table-bordered table-striped" id="files_table">
		<thead><tr><th>Include</th><th>File</th></tr></thead>
		<tbody>';
	
	foreach($archive_files as $archive_file)
	{
		echo '<tr>';
		echo form_hidden('file[' . $archive_file->id . '][]', 'file_in_set');
		echo '<td>' . form_checkbox('file[' . $archive_file->id . '][]', 'include', TRUE) . '</td>';
		echo '<td>' . $archive_file->title . '</td></tr>';
	}
	echo '</tbody></table>';
	
	
	
	echo '<div class="form-actions">';
	
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button> <button type="reset" class="btn btn-warning">Reset</button>';
	echo '</div>';
	
	
		
	echo form_close(); 
	
	
	foreach ($archive_files as $archive_file)
	{
		$available_files[$archive_file->id] = $archive_file->title;
	}

	echo '<div class="control-group">';
	echo form_label('Add File', 'add_file_to_file_set', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_dropdown('add_file', $available_files, set_value('add_file'), 'id="add_file_to_file_set" class="span4"');
	echo '<a name = "add_file_to_file_set" id = "add_file" value = "add_file_to_file_set" class="btn btn-add"><i class = "icon-plus"></i> Add File</a>'; ?>
	
</div>

<script type="text/javascript">

	$('#add_file').click(function()
	{
		file_name = $('#add_file_to_file_set').val();
		file_title = $('#add_file_to_file_set option:selected').text();
		$('#files_table').append('<tr><input type="hidden" name="file[' + file_name + '][]" value="file_in_set" /><td><input type="checkbox" name="file[' + file_name + '][]" value="include" checked="checked"  /></td><td>' + file_title + '<span class="label label-success">New</span></td></tr>');
	});
</script>