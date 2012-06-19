<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li class="active">
		{project_name}
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

<p><!--<a class="btn disabled btn-small"><i class="icon-calendar"></i> Add Timeline Event</a> --><a href="#addTLComment" data-toggle="modal" class="btn btn-small"><i class="icon-pencil"></i> Add Comment</a></p>
		
<?php

echo form_open(site_url('project/' . $project_id . '/timeline/comment'), array(
			'class' => 'modal fade',
			'id' => 'addTLComment'
		));

echo '<div class="modal-header">
	<button class="close" data-dismiss="modal">×</button>
	<h3>Add Comment to Timeline</h3>
</div>
<div class="modal-body">';

$form_comment = array(
	'name'        => 'comment',
	'id'          => 'commentBox',
	'placeholder' => 'Lorem ipsum dolor sit amet...',
	'style'       => 'width:100%;'
);

echo form_label('What do you want to say?', 'commentBox');
echo form_textarea($form_comment);

echo '</div>
<div class="modal-footer">
	<button class="btn" data-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-success"><i class="icon-pencil"></i> Add Comment</button>
</div>';

echo form_close();

?>

<hr>

<?php

if ($new_project === TRUE)
{
	echo '<div class="alert alert-info">
		<i class="icon-chevron-down"></i> Please describe your project in more detail by clicking the \'Edit\' button.
	</div>';

}

else if (isset ($data_required))
{
	echo '<div class="alert alert-info">
		<i class="icon-chevron-down"></i> Please describe your project in more detail by clicking the \'Edit\' button.
	</div>';
}
?>

<p>

{project_controls}
<a class="btn btn-small" href="{uri}">{title}</a>
{/project_controls}

</p>

<hr>

<div class="row">

	<!--

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
				
				<hr>
				
				<p><a href="#" class="btn disabled"><i class="icon-folder-open icon-white"></i> Create Shared Workspace</a>';
			}
			
			?>
			
		</div>
	</div>
	
	-->
	
	<div class="span4">
		<div class="well">
			<h2>Dynamic Datasets</h2>
			
			<?php
			
			if (count($datasets) > 0)
			{
			
				echo '<ul class="nav nav-list">';
				
				foreach ($datasets as $dataset)
				{				
					if ($dataset->visibility === 'public')
					{
						$priv_icon = 'open';
					}
					else
					{
						$priv_icon = 'close';
					}
				
					echo '<li><a href="' . site_url('dataset/' . $dataset->id) . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $dataset->name . '</a></li>';
				}
				
				echo '<li class="divider"></li>
				<li><a href="{base_url}project/{project_id}/datasets"><i class="icon-list"></i> View All</a></li>';

				echo '</ul>';
			
			}
			else
			{
				echo '<p>This project doesn\'t have any dynamic datasets.</p>
				<p>A dynamic dataset lets you directly manipulate your project data and perform complex queries on it.</p>';
			}
			
			?>
			
			<hr>
			
			<p><a href="{base_url}project/{project_id}/datasets/add" class="btn btn-success btn-small"><i class="icon-plus"></i> Create Dynamic Dataset</a>
			
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
				
					echo '<li><a href="' . base_url() . 'file/' . $archive_file->id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $archive_file->title . ' ';
						
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
				<li><a href="{base_url}project/{project_id}/files"><i class="icon-list"></i> View All</a></li>';
				echo '</ul>
				
				<script type="text/javascript">
					$(\'.labeltip\').popover({placement:\'top\'});
				</script>';
				
			}
			else
			{
				echo '<p>This project doesn\'t have any archive files saved. Archive files to permanently store and publish data.</p>';
			}
				

			echo '<a href="{base_url}project/' . $project_id .'/files/add" class="btn btn-success btn-small"><i class="icon-upload"></i> Upload File</a>';
					
			?>
			<!--
			<div class="modal fade" id="uploadFileDialogue">
			
				<div class="modal-header">
					<button class="close" data-dismiss="modal">×</button>
					<h3>Upload File to Archives</h3>
				</div>
				<div class="modal-body">
					<iframe style="width:100%;border:none;height:400px;" src="{orbital_core_location}fileupload/form?token=<?php echo $upload_token; ?>&amp;licence=<?php echo $project_default_licence; ?>"></iframe>
				</div>
				<div class="modal-footer">
					<a class="btn" href="<?php echo site_url('project/{project_id}'); ?>">Done</a>
				</div>
			</div>
			-->
		</div>
	</div>
	
	<div class="span4">
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
				
					echo '<li><a href="' . base_url() . 'collection/' . $file_set->file_set_id . '"><i class="icon-eye-' . $priv_icon . '"></i> ' . $file_set->file_set_name . '</a></li>';
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
			
			<p><a class="btn btn-success btn-small btn-disabled" href="{base_url}project/{project_id}/collections/add"><i class="icon-plus"></i> Create Collection</a></a>
		</div>
	</div>
	
</div>