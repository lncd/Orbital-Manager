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
			<tr><th colspan="2">File Set Summary</th></tr>
		</thead>
		<tbody>
			<tr><td>Dataset Name</td><td>{dataset_title}</td></tr>
			<tr><td>Research Project</td><td><a href="{base_url}project/{dataset_project_id}">{dataset_project}</a></td>			</tr>
		</tbody>
	</table>
</div>

<!-- Documentation -->

THINGS GO HERE



<br><br>

<!--
<table class = "table table-bordered table-striped" id="users_table">

	<thead><tr><th>Action</th><th>File size</th><th>Uploaded</th><th>Licence</th></tr></thead>
	<tbody>

	</tbody>

</table>
-->
		
{file_controls}
<a class="btn btn-small disabled" href="{uri}">{title}</a>
{/file_controls}
