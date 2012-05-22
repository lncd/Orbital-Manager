<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{file_project_id}">{file_project}</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}file/{file_id}">{file_title}</a> <span class="divider">/</span>
	</li>
	<li>
		Edit
	</li>
</ul>

<div class="page-header">
	<h1>{file_title}</h1>
</div>


<div class="well">
	<table class="table">
		<thead>
			<tr><th colspan="2">File Summary</th></tr>
		</thead>
	</table>
	
	<?php echo form_open('file/{file_id}/edit', array('class' => 'form-horizontal'));
	
	$form_name = array(
		'name'			=> 'name',
		'id'			=> 'file_title',
		'placeholder'	=> 'File Name',
		'value'			=> set_value('name', $file_title),
		'maxlength'		=> '200',
		'class'			=> 'span6'
	);

	echo '<div class="control-group">';
	echo form_label('File Name', 'file_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_name);
	echo '</div></div>';
	
	$form_public = array(
		'name'		=> 'public',
		'id'		=> 'file_public',
		'value'		=> 'public',
		'checked'	=> set_checkbox('public', 'public', $file_public_view)
	);

	echo '<div class="control-group">';
	echo form_label('Publish This File', 'file_public', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_checkbox($form_public);
	echo '<p class="help-block">This creates a public web page for this file where people can view and download it.</p>';
	echo '</div></div>';
	
	foreach ($licences as $licence)
	{
		$available_licences[$licence->id] = $licence->name;
	}

	echo '<div class="control-group">';
	echo form_label('Default Licence', 'file_licence', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $file_licence), 'id="file_licence" class="span4"');
	echo '<p class="help-block">Choosing a licence makes it easier to publish and share your data.</p>';
	echo '</div></div>';	

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button> <button type="reset" class="btn btn-warning">Reset</button>';
	echo '</div>';
		
	echo form_close(); ?>
</div>