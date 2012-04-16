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

		<h1>{project_name}</h1>
		
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
			<div class="container">
				<div class = "row">
					<div class = "span6"><b>Project Start</b><br>{project_startdate_pretty}
					</div>
					<div class = "span6" style = "text-align:right"><b>Project End</b><br>{project_enddate_pretty}
					</div>
				</div>
			</div>
		</div>
		
		<?php } ?>
	</div>
</div>

<div class="row">
	<div class="span4">
		<div class="well">
			<h2>Workspace</h2>
		</div>
	</div>
	<div class="span4">
		<div class="well">
			<h2>Working Data</h2>
		</div>
	</div>
	<div class="span4">
		<div class="well">
			<h2>File Archives</h2>
			
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
		</div>
	</div>
</div>