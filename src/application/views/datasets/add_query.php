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
	

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Query</button>';
	echo '</div>';
	
	echo form_close();
	
?>
	
</div>