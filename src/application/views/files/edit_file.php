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
	<h1>{file_title}<small> Edit</small></h1>
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

	$publicity['public'] = 'Public';
	$publicity['visible'] = 'Public - No Download';
	$publicity['private'] = 'Private';

	echo '<div class="control-group">';
	echo form_label('Publish This File', 'file_public', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_dropdown('publicity', $publicity, set_value('publicity', $file_visibility), 'id="file_licence" class="span4"');
	echo '<p class="help-block">This creates a public web page for this file where people can view and download it.</p>';
	echo '</div></div>';
	
	if (count($licences) > 0)
	{
		foreach ($licences as $licence)
		{
			$available_licences[$licence->id] = $licence->name;
		}
	
	echo '<div class="control-group">';
	echo form_label('Default Licence', 'file_licence', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $file_licence), 'id="file_licence" class="span4"');
	echo '<p class="help-block">Choosing a default licence makes it easier to publish and share your data. However, you can still change it on a case-by-case basis for individual files and datasets.</p>';
	echo '
	<br>
	<div class="well" style="background:#FDFDFD">
	
		<div id="licenceAllow" style="display:none">
			<h4>This licence allows:</h4>
			<div id="licenceAllowContent">
			</div>
		</div>
		
		<div id="licenceDeny" style="display:none">
			<h4>This licence forbids:</h4>
			<div id="licenceDenyContent">
			</div>
		</div>
		
		<div id="licenceConditions" style="display:none">
			<h4>This licence has the following conditions:</h4>
			<div id="licenceConditionsContent">
			</div>
		</div>
		
		<h4>Read More</h4>
		<p>More information about this licence, including legal text, is available at:<br>
		<span id="licenceInfoURL"><a href="' . $licence->uri . '" target="_blank">' . $licence->uri . ' <i class="icon-external-link"></i></a></span></p>
	</div>
</div>
</div>';	}
	else
	{
		$available_licences[$file_licence] = $file_licence_name;
		
		echo '<div class="control-group">';
		echo form_label('Default Licence', 'file_licence', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $file_licence), 'id="file_licence" class="span4"');
		echo '<br><br>
		<div class="well" style="background:#FDFDFD">
		
			<div id="licenceAllow" style="display:none">
				<h4>This licence allows:</h4>
				<div id="licenceAllowContent">
				</div>
			</div>
			
			<div id="licenceDeny" style="display:none">
				<h4>This licence forbids:</h4>
				<div id="licenceDenyContent">
				</div>
			</div>
			
			<div id="licenceConditions" style="display:none">
				<h4>This licence has the following conditions:</h4>
				<div id="licenceConditionsContent">
				</div>
			</div>
			
			<h4>NO LICENCES ARE ENABLED</h4>
			<p>Only the licence this file currently has can be selected</p>
		</div>';
		echo '</div></div>';
	}
	

	$available_file_sets = Array();
	foreach ($archive_file_sets_project as $archive_file_set)
	{
		$available_file_sets[$archive_file_set->file_set_id] = $archive_file_set->file_set_name;
	}
	
	if (count($available_file_sets) > 0)
	{
		echo '<div class="control-group">';
		echo form_label('Collections', 'add_fileset_to_file', array('class' => 'control-label'));
		echo '<div class="controls">';
		$table_hidden = '';
		if(count($archive_file_sets) === 0)
		{
			$table_hidden = ' style="display:none"';
		}
		echo '<table' . $table_hidden . ' class = "table table-bordered table-striped" id="file_sets_table">
		<thead><tr><th>Include In</th><th>File Set</th></tr></thead>
		<tbody>';
	
		foreach($archive_file_sets as $archive_file_set)
		{
			echo '<tr>';
			echo form_hidden('file[' . $archive_file_set->file_set_id . '][]', 'file_in_set');
			echo '<td>' . form_checkbox('file[' . $archive_file_set->file_set_id . '][]', 'include', TRUE) . '</td>';
			echo '<td>' . $archive_file_set->file_set_name . '</td></tr>';
		}
		echo '</tbody></table>';
		echo form_dropdown('add_file_set', $available_file_sets, set_value('add_file'), 'id="add_fileset_to_file" class="span4"');
		echo ' <a name = "add_fileset_to_file" id = "add_file_set" value = "add_fileset_to_file" class="btn btn-small"><i class = "icon-plus"></i> Add to Collection</a>';
		echo '</div></div>';
	}
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button> <button type="reset" class="btn btn-warning">Reset</button>';
		echo '</div>';
		
	echo form_close();
 ?>
	
</div>

<script type="text/javascript">

	$('#add_file_set').click(function()
	{
		file_set_name = $('#add_fileset_to_file').val();
		file_set_title = $('#add_fileset_to_file option:selected').text();
		$('#file_sets_table').append('<tr><input type="hidden" name="file[' + file_set_name + '][]" value="file_set_in_file" /><td><input type="checkbox" name="file[' + file_set_name + '][]" value="include" checked="checked"  /></td><td>' + file_set_title + ' <span class="label label-success">New</span></td></tr>');
		$('#file_sets_table').show();
	});
	
	$.getJSON('{base_url}licence/' + $('#file_default_licence').val() + '/json', function(data) {
	
		if (data.allow !== null)
		{
			$('#licenceAllowContent').html(data.allow);
			$('#licenceAllow').show();
		}
		
		if (data.conditions !== null)
		{
			$('#licenceConditionsContent').html(data.conditions);
			$('#licenceConditions').show();
		}
		
		if (data.forbid !== null)
		{
			$('#licenceDenyContent').html(data.forbid);
			$('#licenceDeny').show();
		}
		
		$('#licenceInfoURL').html('<a href="' + data.summary_uri + '" target="_blank">' + data.summary_uri + ' <i class="icon-external-link"></i></a>');
	  
	});
	
	$('#file_licence').change(function(){
	
			
		$.getJSON('{base_url}licence/' + $('#file_licence').val() + '/json', function(data) {
		  
			if (data.allow !== null)
			{
				$('#licenceAllowContent').html(data.allow);
				$('#licenceAllow').show();
			}
			else
			{
				$('#licenceAllow').hide();
			}
			
			if (data.conditions !== null)
			{
				$('#licenceConditionsContent').html(data.conditions);
				$('#licenceConditions').show();
			}
			else
			{
				$('#licenceConditions').hide();
			}
			
			if (data.forbid !== null)
			{
				$('#licenceDenyContent').html(data.forbid);
				$('#licenceDeny').show();
			}
			else
			{
				$('#licenceDeny').hide();
			}
			
			$('#licenceInfoURL').html('<a href="' + data.summary_uri + '" target="_blank">' + data.summary_uri + ' <i class="icon-external-link"></i></a>');
		  
		});
	  
	});
	
</script>