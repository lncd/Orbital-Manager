<div class="row">
	<div class="span12">

		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}project/{project_id}">{project_name}</a></span>
			</li>
		</ul>

		<div class="page-header">
			<h1>{project_name}</h1>
		</div>
		
		{project_description}
		{project_controls}
		<a class="btn btn-small" href="{uri}">{title}</a>
		{/project_controls}
		
		
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
	<div class="span4">
		<div class="well">
			<h2>Workspace</h2>
			
				<h3>Shared Space</h3>
			
			<?php
			
			if ($workspace_project)
			{
			
			}
			else
			{
				echo '<p>This project doesn\'t yet have a shared workspace. You can use a shared workspace to share files and data with colleagues.</p>
				<p><a href="#" class="btn btn-success disabled"><i class="icon-folder-open icon-white"></i> Create Shared Workspace</a>';
			}
			
			echo '<h3>Personal</h3>';
			
			if ($workspace_personal)
			{
			
			}
			else
			{
				echo '<p>You don\'t yet have a personal workspace for this project. You can use a personal workspace to store your files safely, and access them from anywhere.</p>
				<p><a href="#" class="btn btn-success disabled"><i class="icon-folder-open icon-white"></i> Create Personal Workspace</a>';
			}
			
			?>
			
		</div>
	</div>
	<div class="span4">
		<div class="well">
			<h2>Working Data</h2>
			
			<?php
			
			if (count($working_datasets) > 0)
			{
			
			}
			else
			{
				echo '<p>This project doesn\'t have any working datasets.</p>
				<p>A working dataset lets you directly manipulate your project data and perform complex queries on it.</p>';
			}
			
			?>
			
			<p><a href="#" class="btn btn-success disabled"><i class="icon-plus icon-white"></i> Create Dataset</a>
			
		</div>
	</div>
	<div class="span4">
		<div class="well">
			<h2>File Archives</h2>
			
			<!--
			
			<?php
			
			$this->load->helper('number');
			
			$archives_available = 26843545600;
			$archives_used = 23833543500;
			
			$archive_percentage = ceil(($archives_used / $archives_available) * 100);
			
			?>
			
			<div class="progress">
			  <div class="bar"
			       style="width: <?php echo $archive_percentage; ?>%;"></div>
			</div>
			
			<p>You have used <?php echo byte_format($archives_used); ?> of <?php echo byte_format($archives_available); ?>.</p>
			
			-->
			
			<?php
			
			if (count($archive_files) > 0)
			{
			
			}
			else
			{
				echo '<p>You don\'t have any archive files stored in this project.</p>
				<p>Archive files let you permanently store and publish your data in whatever format you think is best.';
			}
			
			?>
			
			<p><a href="#" class="btn btn-success disabled"><i class="icon-upload icon-white"></i> Upload Files</a>
			
		</div>
	</div>
</div>