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
		<a href="{base_url}dataset/{query_dataset}">{dataset_title}</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}query/{query_id}">{query_name}</a> <span class="divider">/</span>
	</li>
	<li class="active">
		Edit Query
	</li>
</ul>

<div class="page-header">
	<h1>{query_name}<small> Edit</small></h1>
</div>
	
<div class="well">
	<table class="table">
		<thead>
			<tr><th colspan="2">Query Statements</th></tr>
		</thead>
	</table>
	
<?php echo form_open('query/{query_id}/edit', array('class' => 'form-horizontal'));
	
	$form_name = array(
		'name'			=> 'query_name',
		'id'			=> 'query_name',
		'placeholder'	=> $query_name,
		'value'			=> set_value('query_name', $query_name),
		'maxlength'		=> '200',
		'class'			=> 'span6',
		'required'		=> 'TRUE'
	);

	echo '<div class="control-group">';
	echo form_label('Query Name', 'query_name', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_name);
	echo '</div></div>';	
	
	//ARRAY OF OPERATORS TO SELECT
	$form_operators = Array();

	$form_operators['equals'] = 'Equals';
	$form_operators['gt'] = 'Greater than';
	$form_operators['gte'] = 'Greater than or equal to';
	$form_operators['lt'] = 'Less than';
	$form_operators['lte'] = 'Less than or equal to';
	
	
	echo '<div class="control-group">';
	echo form_label('Statements', 'add_statements', array('class' => 'control-label'));
	echo '<div class="controls">';
	
	echo '<table class = "table table-bordered table-striped" id="statements_table">
	<thead><tr><th>Field</th><th>Operator</th><th>Value</th><th>Use this statement?</th></tr></thead>
	<tbody>';
	if (isset($statements))
	{
		foreach ($statements as $field => $operators)
		{
			foreach ($operators as $operator => $value)
			{
				echo '<tr><td>' . $field . ' </td><td>' . $operator .  ' </td><td>' . $value . ' </td><td><input type="checkbox" name="include[' . $field . '][' . $operator . ']" value="include" checked="checked"  /><input type="hidden" name="statements[' . $field . '][' . $operator . ']" value="' . $value . '"/></td></tr>';
				
			}
		}

	}

	echo '</tbody></table></div>';
	
	echo '<div class="control-group">';
	echo form_label('Output fields', 'add_output_field', array('class' => 'control-label'));
	echo '<div class="controls">';
	
	echo '<table class = "table table-bordered table-striped" id="output_fields_table">
	<thead><tr><th>Field</th><th>Use this output field?</th></tr></thead>
	<tbody>';
	if (isset($fields))
	{
		foreach ($fields as $field)
		{
			echo '<tr><td>' . $field . ' </td><td><input type="checkbox" name="output_fields[]" value="' . $field . '" checked="checked"  /></td></tr>';
		}

	}

	echo '</tbody></table>';
	
	echo '</div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Query</button>';
	echo '</div>';
	
	echo form_close();
	
	
		$form_field = array(
		'id'			=> 'field',
		'placeholder'	=> 'Field',
		'maxlength'		=> '200',
		'class'			=> 'span3'
	);

	echo form_input($form_field);
	echo ' ';
	echo form_dropdown('operators', $form_operators, set_value('operator'), 'id="operator" class="span3"');
	echo ' ';
	
		$form_value = array(
		'id'			=> 'value',
		'placeholder'	=> 'Value',
		'maxlength'		=> '200',
		'class'			=> 'span3'
	);

	echo form_input($form_value);	
	
	echo ' <a name = "add_statement_to_query" id = "add_statement" value = "add_statement_to_query" class="btn btn-small"><i class = "icon-plus"></i> Add statement</a>';
	
	echo '<br>';
	echo '<br>';
	
		$form_field = array(
		'id'			=> 'output_field',
		'placeholder'	=> 'Output field',
		'maxlength'		=> '200',
		'class'			=> 'span3'
	);
	
	echo form_input($form_field);
	echo ' <a name = "add_output_field_to_query" id = "add_output_field" value = "add_output_field_to_query" class="btn btn-small"><i class = "icon-plus"></i> Add Output field</a>';

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
</script>