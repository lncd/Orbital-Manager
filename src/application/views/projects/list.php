<div class="row">
	<div class="span12">
	
		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}projects">Projects</a></span>
			</li>
		</ul>
	
		<div class="page-header">
			<h1>Your Projects</h1>
		</div>

	</div>
</div>

<h2>Activity Timeline</h2>
<div class="well">
<?php

if (count($timeline) > 0)
{
	echo '<ul class="timeline" id="userTimeline">';

	foreach ($timeline as $item)
	{
		echo '<li id="tl_' . $item->id . '"><div class="tl_content tl_vis_' . $item->visibility . '"><p><b>' . $item->text . '</b>';
		if ($item->payload !== NULL)
		{
			echo '<br>' . $item->payload;
		}
		echo '</p><small>' . $item->timestamp_human . '</small></div></li>';
	}	
	
	echo '</ul>';
}
else
{
	echo 'There isn\'t any recent activity to show.';
}

?>

<script type="text/javascript" src="{base_url}js/jquery.scrollTo.min.js"></script>
<script type="text/javascript">
	$('#userTimeline').scrollTo($('#tl_now'));
</script>

</div>
<div class="row">
	<div class="span8">
		<table class="table table-striped table-bordered">
			<thead>
				<tr><th>Name</th><th>Start</th><th>End</th></tr>
			</thead>
			<tbody>
				{projects}
				<tr><td><a href = "{project_uri}">{project_name}</a> <th>{project_startdate}</th><th>{project_enddate}</td></tr>
				{/projects}
			</tbody>
		</table>
	</div>
	<div class="span4">
		<div class="well">
			<h2>Create A Project</h2>
			<form method="post" action="{base_url}projects/create">
				<label for="project_name">Project Name</label>
				<input type="text" id="project_name" name="name" placeholder="My Research Project" required>
				<label for="project_abstract">Project Description</label>
				<textarea id="project_abstract" name="abstract" rows="4" placeholder="This is a project which…" required></textarea>
				<button type="submit" class="btn btn-success"><i class = "icon-plus icon-white"></i> Create Project</button>
			</form>

		</div>
		<div class="well">
			<h2>Recent Public Projects</h2>
			
			<ul class="nav nav-list">
				
				{public_projects}
				<li>
					<a href = "{project_uri}/public"><i class="icon-chevron-right"></i>{project_name}</a>
				</li>
				{/public_projects}
				<li class="divider"></li>
				<li><a href="{base_url}projects/public"><i class="icon-list"></i> View All</a></li>
			</ul>
		</div>
	</div>
</div>