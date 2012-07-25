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
	<li>
		<a href="{base_url}dataset/{query_id}">{query_name}</a> <span class="divider">/</span>
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
	echo form_label('Query', 'add_statements', array('class' => 'control-label'));
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

	echo '</tbody></table>';
	echo '</div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Query</button>';
	echo '</div>';
	
	echo form_close();
	
	
		$form_field = array(
		'name'			=> 'field',
		'id'			=> 'field',
		'placeholder'	=> 'Field',
		'maxlength'		=> '200',
		'class'			=> 'span3',
		'required'		=> 'TRUE'
	);

	echo form_input($form_field);
	echo ' ';
	echo form_dropdown('operators', $form_operators, set_value('operator'), 'id="operator" class="span3"');
	echo ' ';
	
		$form_value = array(
		'name'			=> 'value',
		'id'			=> 'value',
		'placeholder'	=> 'Value',
		'maxlength'		=> '200',
		'class'			=> 'span3',
		'required'		=> 'TRUE'
	);

	echo form_input($form_value);	
	
	echo ' <a name = "add_statement_to_query" id = "add_statement" value = "add_statement_to_query" class="btn btn-small"><i class = "icon-plus"></i> Add statement</a>';
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
</script>