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
	<li class="active">
		{query_name}
	</li>
</ul>

<div class="page-header">
	<h1>{query_name}</h1>
</div>
<div class = "well">
	<table class="table">
		<thead>
			<tr><th colspan="2">Dynamic Dataset Summary</th></tr>
		</thead>
		<tbody>
			<tr><td>Query Name</td><td>{query_name}</td></tr>
			<tr><td>Query Dataset</td><td><a href="{base_url}dataset/{query_dataset}">{dataset_title}</a></td></tr>
			<tr><td>Results</td><td>{query_results_count}</td></tr>
		</tbody>
	</table>
</div>

<?php

//Check for Edit permissions
if (TRUE)
{
	echo '<p>';
	
	echo '<a href="' . site_url('query/' . $query_id . '/edit') . '" class="btn btn-small"><i class="icon-pencil"></i> Edit</a>';
		
	
	// Check for Delete permissions
	if (TRUE)
	{								
		echo ' <a href="#delete_query" data-toggle="modal" class="btn btn-small btn-danger"><i class="icon-trash"></i> Delete</a>';
	}
	
	echo '</p>';
}
?>

<br>
<h2>Statements</h2>
<br>

<table class="table table-bordered">
	<thead>
		<tr><th>Field</th><th>Operator</th><th>Value</th></tr>
	</thead>
	<tbody>
		<?php			
			if (isset($statements))
			{
				foreach ($statements as $field => $operators)
				{
					foreach ($operators as $operator => $value)
					{
						echo '<tr><td>' . $field . ' </td><td>' . $operator .  ' </td><td>' . $value . ' </td></tr>';
						
					}
				}
		
			}
			?>
		
		</td></tr>
	</tbody>
</table>


<br>
<h2>Output Fields</h2>
<br>

		<?php	
		if (isset($fields))
		{
			echo'<ul>';
			foreach ($fields as $field)
			{
				echo '<li>' . $field . '</li>';
			}
			echo'</ul>';	
		}

echo '<div class="modal fade" id="delete_query">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>Delete Query</h3>
			<h4>' . $query_name . '</h4>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete this query?</p>
		</div>
		<div class="modal-footer">
			<a href="#" data-dismiss="modal" class="btn">Close</a>
			<a href="' . site_url('query/' .  $query_id . '/delete') . '" class="btn btn-danger"><i class="icon-trash"></i> Delete Query</a>
		</div>
	</div>';


