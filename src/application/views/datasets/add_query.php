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
		<a href="{base_url}project/{dataset_project_id}/{dataset_project}">{dataset_title}</a><span class="divider">/</span>
	</li>
	<li class="active">
		Query Builder
	</li>
</ul>

<div class="page-header">
	<h1>Query Builder</h1>
</div>
	
<div class="well">
	<table class="table">
		<thead>
			<tr><th colspan="2">Query Statements</th></tr>
		</thead>
	</table>
	
<?php echo form_open('dataset/{dataset_id}/query', array('class' => 'form-horizontal'));
	
	$form_name = array(
		'name'			=> 'query_name',
		'id'			=> 'query_name',
		'placeholder'	=> 'Query Name',
		'maxlength'		=> '200',
		'class'			=> 'span6',
		'required'		=> 'TRUE'
	);

	echo '<div class="control-group">';
	echo form_label('Query Name', 'query_name', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_name);
	echo '</div></div>';
	
	$form_output_fields = array(
		'name'			=> 'output_fields',
		'id'			=> 'output_fields',
		'placeholder'	=> 'Output Fields',
		'maxlength'		=> '200',
		'class'			=> 'span6',
		'required'		=> 'TRUE'
	);

	echo '<div class="control-group">';
	echo form_label('Output Fields', 'output_fields', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_output_fields);
	echo '</div></div>';
	
	
	//ARRAY OF OPERATORS TO SELECT
	$operators = Array();

	$operators['equals'] = 'Equals';
	$operators['gt'] = 'Greater than';
	$operators['gte'] = 'Greater than or equal to';
	$operators['lt'] = 'Less than';
	$operators['lte'] = 'Less than or equal to';
	
	
	echo '<div class="control-group">';
	echo form_label('Query', 'add_statements', array('class' => 'control-label'));
	echo '<div class="controls">';
		$table_hidden = ' style="display:none"';
	
	echo '<table' . $table_hidden . ' class = "table table-bordered table-striped" id="statements_table">
	<thead><tr><th>Field</th><th>Operator</th><th>Value</th><th>Use this statement?</th></tr></thead>
	<tbody>';
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
	echo form_dropdown('operators', $operators, set_value('operator'), 'id="operator" class="span3"');
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
		$('#statements_table').append('<tr><td>' + field + ' </td><td>' + operator + ' </td><td>' + value + ' </td><td><input type="checkbox" name="file[' + field + '][]" value="include" checked="checked"  /><input type="hidden" name="statements[' + field + '][' + operator + ']" value="' + value + '"/></td></tr>');
		$('#statements_table').show();
	});
</script>