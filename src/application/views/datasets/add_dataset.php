<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{file_set_project}">{file_set_project_name}</a> <span class="divider">/</span>
	</li>	
	<li class="active">
		Add New Dataset
	</li>
</ul>

<div class="page-header">
	<h1>Add New Datset</h1>
</div>

<div class="well">
	<h2>Dataset Details</h2>
	<br>
	
	<?php echo form_open('project/{file_set_project}/datasets/add', array('class' => 'form-horizontal'));
	
	$form_name = array(
		'name'			=> 'dataset_name',
		'id'			=> 'dataset_name',
		'placeholder'	=> 'Dataset Name',
		'value'			=> set_value('name', ''),
		'maxlength'		=> '200',
		'class'			=> 'span6'
	);

	echo '<div class="control-group">';
	echo form_label('Dataset Name', 'dataset_name', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_name);
	echo '</div></div>';
	
	$form_abstract = array(
		'name'			=> 'dataset_description',
		'id'			=> 'dataset_description',
		'placeholder'	=> 'A bit about this dataset...',
		'value'			=> set_value('abstract', ''),
		'rows'			=> '5',
		'class'			=> 'span6'
	);

	echo '<div class="control-group">';
	echo form_label('Dataset Description', 'dataset_description', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_textarea($form_abstract);
	echo '</div></div>';
	
	
	echo '<div class="form-actions">';
	
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button> <button type="reset" class="btn btn-warning">Reset</button>';
	echo '</div>';
	
	
		
	echo form_close(); 
	echo '</div>';
	