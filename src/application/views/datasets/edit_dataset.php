<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{dataset_project_id}">{dataset_project}</a> <span class="divider">/</span>
	</li>	
	<li>
		<a href="{base_url}dataset/{dataset_id}">{dataset_title}</a><span class="divider">/</span>
	</li>
	<li class="active">
		Edit Dataset
	</li>
</ul>

<div class="page-header">
	<h1>{dataset_title}<small> Edit</small></h1>
</div>
	
<div class="well">

	
<?php echo form_open('dataset/{dataset_id}/edit', array('class' => 'form-horizontal'));

	$form_name = array(
		'name'			=> 'dataset_title',
		'required'    => 'required',
		'id'			=> 'dataset_title',
		'placeholder'	=> 'Dataset Name',
		'value'			=> set_value('name', $dataset_title),
		'maxlength'		=> '200',
		'class'			=> 'span6'
	);

	echo '<div class="control-group">';
	echo form_label('Dataset Name', 'dataset_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_name);
	echo '</div></div>';
	
	$form_abstract = array(
		'name'			=> 'dataset_description',
		'required'    => 'required',
		'id'			=> 'dataset_description',
		'placeholder'	=> 'A bit about this project...',
		'value'			=> set_value('abstract', $dataset_description),
		'rows'			=> '5',
		'class'			=> 'span6'
	);

	echo '<div class="control-group">';
	echo form_label('Dataset Description', 'dataset_description', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_textarea($form_abstract);
	echo '</div></div>';
	
		
	$form_public = array(
		'name'		=> 'public',
		'id'		=> 'dataset_visibility',
		'value'		=> 'public',
		'checked'	=> set_checkbox('public', $dataset_visibility)
	);

	echo '<div class="control-group">';
	echo form_label('Public dataset?', 'dataset_visibility', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_checkbox($form_public);
	echo '</div></div>';
	
	
	
	if (count($dataset_licences) > 0)
	{
		foreach ($dataset_licences as $licence)
		{
			$available_licences[$licence->id] = $licence->name;
		}
	
	echo '<div class="control-group">';
	echo form_label('Default Licence', 'dataset_licence', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $dataset_licence), 'id="dataset_licence" class="span4"');
	echo '<p class="help-block">Choosing a default licence makes it easier to publish and share your data.</p>';
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
		$available_licences[$dataset_licence] = $dataset_licence_name;
		
		echo '<div class="control-group">';
		echo form_label('Default Licence', 'dataset_licence', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('default_licence', $available_licences, set_value('default_licence', $dataset_licence), 'id="dataset_licence" class="span4"');
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
			<p>Only the licence this dataset currently has can be selected</p>
		</div>';
		echo '</div></div>';
	}
	
	
	
	
	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Dataset</button>';
	echo '</div>';
	
	echo form_close();
	

?>
	
</div>

<script type="text/javascript">

	$('#add_statement').click(function()
	{
		field = $('#field').val();
		operator = $('#operator').val();
		value = $('#value').val();
		$('#statements_table').append('<tr><td>' + field + ' </td><td>' + operator + ' </td><td>' + value + ' </td><td><input type="checkbox" name="include[' + field + '][' + operator + ']" value="include" checked="checked"  /><input type="hidden" name="statements[' + field + '][' + operator + ']" value="' + value + '"/></td></tr>');
		$('#statements_table').show();
	});
	
	$('#add_output_field').click(function()
	{
		output_field = $('#output_field').val();
		$('#output_fields_table').append('<tr><td>' + output_field + ' </td><td><input type="checkbox" name="output_fields[]" value="' + output_field + '" checked="checked"  /></td></tr>');
	});
	
	
	$.getJSON('{base_url}licence/' + $('#dataset_default_licence').val() + '/json', function(data) {
	
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
	
	$('#dataset_licence').change(function(){
	
			
		$.getJSON('{base_url}licence/' + $('#dataset_licence').val() + '/json', function(data) {
		  
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