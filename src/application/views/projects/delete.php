<div class="row">
	<div class="span12">

		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
			</li>
			<li>
				<a href="{base_url}project/{project_id}">{project_name}</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}project/{project_id}/delete">Delete</a>
			</li>
		</ul>
		
		<div class="page-header">
			<h1>{project_name} <small>Delete</small></h1>
		</div>
		
		<?php
		$this->load->helper('text');
		echo word_limiter($project_description, 50);
		?>
		
		<hr>
		
		<div class="alert alert-error">
  			<p><strong>Are you sure you want to delete this project?</strong></p>
  			<p>Deleting this project will mean that you can no longer edit any of its details, and will remove any workspaces, unpublished datasets and private archived files.</p>
  			<p>You <em>cannot</em> undo this action.</p>
  			<form method="post" action="{base_url}project/{project_id}/delete">
				<button type="submit" name = "delete" value = "delete" class="btn btn-danger btn-large">Delete</button>
				<a class="btn" href="{base_url}project/{project_id}">No</a>
			</form>
		</div>
	</div>
</div>