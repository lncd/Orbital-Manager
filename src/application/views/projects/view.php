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

		<?php
		
		if (isset($error))
		{
			echo '<div class="alert alert-error alert-block">
  <a class="close" data-dismiss="alert" href="#">×</a>
  <h4 class="alert-heading">Upload Error</h4>
  ' . $error . '
</div>';
		}
		
		if (isset($success))
		{
			echo '<div class="alert alert-success alert-block">
  <a class="close" data-dismiss="alert" href="#">×</a>
  <h4 class="alert-heading">Upload Successful</h4>
  ' . $success . '
</div>';
		}
		
		?>

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
			
			<?php
			
			if ($workspace)
			{
			
			}
			else
			{
				echo '<p>This project doesn\'t yet have a workspace. You can use a workspace to share files and data with colleagues, as well as to keep a backed up history of your work.</p>
				<p><a href="#" class="btn btn-success disabled"><i class="icon-folder-open icon-white"></i> Create Shared Workspace</a>';
			}
			
			?>
			
		</div>
	</div>
	<div class="span4">
		<div class="well">
			<h2>Dynamic Datasets</h2>
			
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
				echo '<p>This project doesn\'t have any dynamic datasets.</p>
				<p>A dynamic dataset lets you directly manipulate your project data and perform complex queries on it.</p>';
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
				
					echo '<li>';
					
					if ($archive_file->status === 'uploaded')
					{
					echo '<a href="' . base_url() . 'file/' . $archive_file->id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $archive_file->original_name . '</a>';
					}
					else
					{
						echo '<i class="icon-eye-' . $priv_icon . '"></i> ' . $archive_file->original_name . ' ';
						
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
					}
					
					echo '</li>';
				}
				
				echo '</ul>
				
				<script type="text/javascript">
					$(\'.labeltip\').popover({placement:\'top\'});
				</script>';
			}
			else
			{
				echo '<p>You don\'t have any archive files stored in this project.</p>
				<p>Archive files let you permanently store and publish your data in whatever format you think is best.';
			}
			
			?>
			
			<p><a href="#uploadFileDialogue" class="btn btn-success" class="btn btn-success" data-toggle="modal"><i class="icon-upload icon-white"></i> Upload File</a>
			
			<?php

			echo form_open_multipart($orbital_core_location . 'files/upload', array(
				'class' => 'modal fade',
				'id' => 'uploadFileDialogue'
			));
			
			echo form_hidden('upload_token', 'foobarbaz');
			echo form_hidden('return_uri', site_url('project/' . $project_id));
			
			?>
			
				<div class="modal-header">
					<button class="close" data-dismiss="modal">×</button>
					<h3>Upload File to Archives</h3>
				</div>
				<div class="modal-body">
					
					<?php
					
					$form_file = array(
						'name'        => 'file',
						'id'          => 'file',
					);
			
					echo form_label('File to be uploaded', 'file');
					echo form_upload($form_file);
					
					$form_public = array(
						'name'	=> 'public',
						'id'	=> 'public',
						'value'	=> 'public',
					);
			
					echo form_label('Make file publicly available?', 'public');
					echo form_checkbox($form_public);
					
					$form_licence = array(
						'name'        => 'licence',
						'id'          => 'licence'
					);
					
					$licences = $this->orbital->licences_enabled_list();
					
					foreach ($licences->response->licences as $licence)
					{
						$file_licences[$licence->id] = $licence->name;
					}
			
					echo form_label('Licence to release this file under (if public)', 'licence');
					echo form_dropdown('licence', $file_licences, $project_default_licence);
					
					?>
					
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success"><i class="icon-upload icon-white"></i> Upload</button>
				</div>
			  
			<?php echo form_close(); ?>
			
		</div>
	</div>
</div>