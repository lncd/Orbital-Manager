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
	<li class="active">
		{dataset_title}
	</li>
</ul>

<div class="page-header">
	<h1>{dataset_title}</h1>
</div>
<div class = "well">
	<table class="table">
		<thead>
			<tr><th colspan="2">Dynamic Dataset Summary</th></tr>
		</thead>
		<tbody>
			<tr><td>Dataset Name</td><td>{dataset_title}</td></tr>
			<tr><td>Research Project</td><td><a href="{base_url}project/{dataset_project_id}">{dataset_project}</a></td></tr>
			<tr><td>Dataset ID</td><td><code>{dataset_id}</code></td></tr>
			<tr><td>API Token</td><td><code>{dataset_token}</code></td></tr>
			<tr><td>Number of Datapoints</td><td>{count}</td></tr>
		</tbody>
	</table>
</div>

		<?php

//Check for Edit permissions
if ($permission_write === TRUE)
{
	echo '<p>';
	
	echo '<a href="' . site_url('dataset/' . $dataset_id . '/edit') . '" class="btn btn-small"><i class="icon-pencil"></i> Edit</a>';
		
	
	// Check for Delete permissions
	if ($permission_delete === TRUE)
	{								
		echo ' <a href="#delete_dataset" data-toggle="modal" class="btn btn-small btn-danger"><i class="icon-trash"></i> Delete</a>';
	}
	
	echo '</p>';
}



echo '<div class="modal fade" id="delete_dataset">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>Delete Dataset</h3>
			<h4>' . $dataset_title . '</h4>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete this dataset?</p>
		</div>
		<div class="modal-footer">
			<a href="#" data-dismiss="modal" class="btn">Close</a>
			<a href="' . site_url('file/' . $dataset_id . '/delete') . '" class="btn btn-danger"><i class="icon-trash"></i> Delete Dataset</a>
		</div>
	</div>';

	echo '<table class = "table table-bordered table-striped table-condensed" id="users_table">';
	if (count($queries) > 0)
	{
		
		echo '<h2>Queries</h2><br>';
	
	?>
		<thead><tr><th>Query name</th></tr></thead>
		<tbody>
		<?php
		if (isset($queries) AND $queries !== FALSE)
		{
			foreach($queries as $query)
			{
				echo '<tr><td>';
					
				echo '<a href="' . base_url() . 'query/' . $query->id . '">' . $query->query . ' '; echo'</td></tr>';

			}
		}

			
		echo '</tbody>';
	}
	else
	{
		echo '<p>There are currently no queries available for this dataset';
	}
	
	echo '</table>';
	echo '<p><a class="btn btn-success btn-small btn-disabled" href="{base_url}dataset/{dataset_id}/query"><i class="icon-plus"></i> Create Query</a></a>';

	?>

<hr>

<h2>Using Dynamic Datasets</h2>

<p>Dynamic Datasets let you store your research data directly in Orbital's database, letting you manipulate it directly using your own simple code.

<h3>Adding/Updating Data</h3>

<p>To add or update data in this Dynamic Dataset you need the Dataset ID and API token (already embedded in the below examples), a basic understanding of JSON, and the ability to make a HTTP POST request.</p>

<p>Make a POST request to <code>{orbital_core_location}dataset/{dataset_id}</code> with the body in the following format:</p>

<pre>
{
	"token": "{dataset_token}",
	"data": [
		{
			"id": "datapoint-1",
			"key1": "value1",
			"key2": 1234
		},
		{
			"id": "datapoint-2",
			"key1": "value3",
			"key2": 5678
		}
		},
		{
			"id": "datapoint-2",
			"key1": "value5",
			"key2": 1234,
			"key3": "value7"
		}
	]
}
</pre>

<p><code>token</code> should be your API Token, and <code>data</code> should be an array of data points to be inserted. Within each data point you can include key/value pairs of data to be stored. If you include a key of <code>id</code> as one of the pairs then this will be used as the unique identifier for that particular data point. If you don't include an <code>id</code> then Orbital will generate one for you.</p>

<p>Values can be any valid JSON data type, including strings, booleans, integers and floating point numbers.</p>

<p>Note that you can use different keys within each different data point &mdash; if you have more data for one point than another (for example including a new sensor in some time-series data) then you don't need to update old data points, just include the data in new ones).</p>

<p>To update a data point, simply make another POST request with the same <code>id</code>. The previous contents of the data point will be archived automatically, and the current 'working' data updated.</p>

<h3>Querying Data</h3>
	
<p>To query this Dynamic Dataset you need the Dataset ID and API token (already embedded in the below examples), a basic understanding of JSON, and the ability to make a HTTP GET request.</p>

<p>Make a POST request to <code>{orbital_core_location}dataset/{dataset_id}/data</code> with the following parameters:</p>

<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>Parameter</th>
			<th>Value</th>
		</tr>
	</thead>
	<tr>
		<td>
			<code>token</code>
		</td>
		<td>
			<code>{dataset_token}</code>
		</td>
	</tr>
	<tr>
		<td>
			<code>q</code>
		</td>
		<td>
			<p>URL encoded JSON object in following format:</p>
			<pre>{
	"statements": {
		"key1": {
			"equals": "value1"
		},
		"key2": {
			"gte": 1000,
			"lt": 1500
		}
	},
	"fields": [
		"key1",
		"key2",
		"key3"
	]
}</pre>

			<p><code>statements</code> is a set of keys, and each key contains a statement which limits the query. The following statement types are valid, and a key may include multiple statements:</p>
			<ul>
				<li>
					<code>equals</code>: The value of the key must be exactly equal to the value given. The value may be any valid type.
				</li>
				<li>
					<code>gt</code>: The value of the key must be greater than the value given. This value must be an integer or floating point number.
				</li>
				<li>
					<code>gte</code>: The value of the key must be greater than or equal to the value given. This value must be an integer or floating point number.
				</li>
				<li>
					<code>lt</code>: The value of the key must be less than the value given. This value must be an integer or floating point number.
				</li>
				<li>
					<code>lte</code>: The value of the key must be less than or equal to the value given. This value must be an integer or floating point number.
				</li>
			</ul>
			<p><code>fields</code> is an array of the keys which should be returned. All other keys will be excluded from the response.</p>
		</td>
	</tr>
</table>