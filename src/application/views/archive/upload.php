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
			<li>
				<a href="{base_url}project/{project_id}/archives">Archives</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}project/{project_id}/archives/upload">Upload</a></span>
			</li>
		</ul>

		<h1>Upload File to Archives</h1>
		
		<div class="row">
			<div class="span8">
				<form id="fileupload" action="{core_url}archive/upload_delegate" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="project_id" value="{project_id}">
		    		<label for="files">Select files to upload</label>
		    		<input type="file" name="files[]" multiple>
		    		<button type="submit" class="btn btn-large btn-success">Upload Files</button>
				</form>
			</div>
			<div class="span4">
				<div class="well">
					<h2>What is this?</h2>
					<p>The 'Core Ping' is {orbital_manager_name} ensuring that it can still communicate with the Orbital Core application, which is actually responsible for storing and managing data. You can generally ignore what the Core Ping tells you, although your system administrator may ask you for information to help them solve problems.</p>
				</div>
			</div>
		</div>
	</div>
</div>