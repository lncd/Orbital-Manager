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
		
		<h2>Project Timeline</h2>
		
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
			echo 'There isn\'t any activity to show for this project.';
		}
		
		?>		
		<script type="text/javascript" src="{base_url}js/jquery.scrollTo.min.js"></script>
<script type="text/javascript">
	$('#userTimeline').scrollTo($('#tl_now'));
</script>
		
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

	<!--

	<div class="span6">
		<div class="well">
			<h2>Dynamic Datasets</h2>
			
			<p>This project hasn't made any dynamic datasets public.</p>
			
			
		</div>
	</div>
	
	-->
	
	<div class="span6">
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
				echo '<ul class="nav nav-list">';
				foreach ($archive_files as $archive_file)
				{
				
					if ($archive_file->visibility === 'public')
					{
						$priv_icon = 'open';
					}
					else
					{
						$priv_icon = 'close';
					}
				
					echo '<li><a href="' . base_url() . 'file/' . $archive_file->id . '/public"><i class="icon-eye-' . $priv_icon . '"></i> ' . $archive_file->original_name . ' ';
						
					switch ($archive_file->status)
					{
					
						case 'placeholder':
							echo '<span class="label label-inverse labeltip" rel="popover" data-content="This file is a placeholder for one due to be manually uploaded by an administrator." data-original-title="Placeholder">Placeholder</span>';
							break;
							
						case 'staged':
							echo '<span class="label label-default labeltip" rel="popover" data-content="This file is queued, waiting to be processed." data-original-title="Queued">Queued</span>';
							break;
							
						case 'uploading':
							echo '<span class="label label-info labeltip" rel="popover" data-content="This file is currently being processed and will be available soon." data-original-title="Processing">Processing</span>';
							break;
							
						case 'upload_error_soft':
							echo '<span class="label label-warning labeltip" rel="popover" data-content="Something has gone wrong processing this file, but it will be retried automatically." data-original-title="Upload Error">Upload Error</span>';
							break;
							
						case 'upload_error_hard':
							echo '<span class="label label-important labeltip" rel="popover" data-content="Something has gone wrong uploading this file, and it cannot be retried. An administrator has been notified." data-original-title="Upload Error">Upload Error</span>';
							break;
					}
					echo '</a></li>';
				}
				
				echo '<li class="divider"></li>
				<li><a href="{base_url}project/{project_id}/public/files"><i class="icon-list"></i> View All</a></li>';
				echo '</ul>
				
				<script type="text/javascript">
					$(\'.labeltip\').popover({placement:\'top\'});
				</script>';
				
			}
			else
			{
				echo '<p>This project doesn\'t have any archive files saved. Archive files to permanently store and publish data.</p>';
			}
						
			?>

		</div>
	</div>
	
	<div class="span6">
		<div class="well">
			<h2>File Collections</h2>
			
			<?php
			
			if (count($file_sets) > 0)
			{
				echo '<ul class="nav nav-list">';
				foreach ($file_sets as $file_set)
				{				
					if ($file_set->file_set_visibility === 'public')
					{
						$priv_icon = 'open';
					}
					else
					{
						$priv_icon = 'close';
					}
				
					echo '<li><a href="' . base_url() . 'collection/' . $file_set->file_set_id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $file_set->file_set_name . ' ';
					
					echo '</a></li>';
				}
				echo '<li class="divider"></li>
				<li><a href="{base_url}project/{project_id}/collections"><i class="icon-list"></i> View All</a></li>';

				echo '</ul>
				
				<script type="text/javascript">
					$(\'.labeltip\').popover({placement:\'top\'});
				</script>';
				
			}
			else
			{
				echo '<p>There aren\'t any file collections associated with this project. File collections can be used to organise archived files.</p>';
			}

			?>
			
		</div>
	</div>
</div>