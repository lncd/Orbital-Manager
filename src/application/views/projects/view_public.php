<div class="row">
	<div class="span12">

		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}projects/public">Public Projects</a> <span class="divider">/</span>
			</li>
			<li class="active">
				{project_name}
			</li>
		</ul>

		<div class="page-header">
			<h1>{project_name}</h1>
		</div>
		
		{project_description}
		
		
		<?php
		
		if (isset ($project_startdate) AND isset($project_enddate))
		{
		
		?>
		
		<div class = "well">
			<h2>Project Progress</h2>
			<div class="progress">
  				<div class="bar" style="width: {project_complete}%;">
  				</div>
  			</div>
  			<div class = "pull-left"><b>Project Start</b><br>{project_startdate_pretty}
			</div>
			<div class = "pull-right"><b>Project End</b><br>{project_enddate_pretty}
			</div>
			<div style = clear:both>
			</div>
		</div>
		
		<?php } ?>
	</div>
</div>

<hr>

<div class="row">
	<div class="span6">
		<div class="well">
			<h2>Working Data</h2>
			
			<?php
			
			if (count($working_datasets) > 0)
			{
			
			?>
			
			<ul class="nav nav-list">
				<li class="nav-header">
					Published
				</li>
				<li>
					<a href="#"><i class="icon-eye-open"></i> Something</a>
				</li>
				<li>
					<a href="#"><i class="icon-eye-open"></i> Something Else</a>
				</li>
				<li class="nav-header">
					Private
				</li>
				<li>
					<a href="#"><i class="icon-eye-close"></i> Something Else</a>
				</li>
				<li>
					<a href="#"><i class="icon-eye-close"></i> Something Else</a>
				</li>
			</ul>
			
			<hr>
			
			<?php
			
			}
			else
			{
				echo '<p>This project doesn\'t have any working datasets.</p>
				<p>A working dataset lets you directly manipulate your project data and perform complex queries on it.</p>';
			}
			
			?>
			
			
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<h2>File Archives</h2>
			
			<?php
			
			if (count($archive_files) > 0)
			{
				foreach ($archive_files as $archive_file)
				{
					echo '<a href = #>' . $archive_file . '</a><br>';
				}
			}
			else
			{
				echo '<p>You don\'t have any archive files stored in this project.</p>
				<p>Archive files let you permanently store and publish your data in whatever format you think is best.';
			}
			
			?>
			
			
		</div>
	</div>
</div>