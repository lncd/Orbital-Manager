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
	
	foreach($archive_files as $archive_file)
		{
		
		?>
		<input type="checkbox" name="remove[<?php echo $archive_file->id;?>]" value="TRUE">
		<?php echo $archive_file->original_name;?>

		<?php
		}
	
	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button> <button type="reset" class="btn btn-warning">Reset</button>';
	echo '</div>';
		
	echo form_close(); ?>
</div>
