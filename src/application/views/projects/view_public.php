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
			<h2>Dynamic Datasets</h2>
			
			<p>This project hasn't made any dynamic datasets public.</p>
			
			
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<h2>File Archives</h2>
			<?php
			
			if (count($archive_files) > 0)
			{
				echo '<ul class="nav nav-list">';
			
				foreach ($archive_files as $archive_file)
				{
					echo '<li><a href="' . base_url() . 'file/' . $archive_file->id . '"><i class="icon-eye-open"></i> ' . $archive_file->original_name . '</a></li>';
				}
				
				echo '</ul>';
			}
			else
			{
				echo '<p>This project hasn\'t made any archived files public.</p>';
			}
			
			?>
			
		</div>
	</div>
</div>