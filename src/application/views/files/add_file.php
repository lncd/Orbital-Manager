<ul class="breadcrumb">
	<li>
		<a href="{base_url}">Home</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}projects">Projects</a> <span class="divider">/</span>
	</li>
	<li>
		<a href="{base_url}project/{file_project}">{file_project_name}</a> <span class="divider">/</span>
	</li>
	<li>
		Upload File
	</li>
</ul>

<div class="page-header">
	<h1>{file_project_name} <small>Upload Files</small></h1>
</div>

<div class="row">
	<div class="span4" id="settings_message_div">
		<div id="settings" class="well">
			<ol class="lead"><li>Choose your settings</li>
			<li>Click 'Next' to start uploading files</li></ol>
			<p><a href="#" class="btn btn-primary" id="next_button"><i class = "icon-arrow-right"></i> Next</a></p>
		</div>
	</div>
	<div class="span8" id="settings_div">
		<?php
		
		if (isset($file_licences) AND count($file_licences) > 0)
		{
			foreach ($file_licences as $licence)
			{
				$available_licences[$licence->id] = $licence->name;
			}
				$publicities['public'] = 'Public';
				$publicities['visible'] = 'Public - No Download';
				$publicities['private'] = 'Private';
			
				
			echo form_label('Make these files publicly available?', 'publicity');
			echo form_dropdown('publicity', $publicities, 'Public', 'id="publicity"');
			echo form_label('Licence to release these files under (if public)', 'licence');
			echo form_dropdown('licence', $available_licences, 0, 'id="licence"');
		
		
			echo '<div class="well">
			
				<div id="licenceAllow" style="display:none">
					<h4>This licence allows:</h4>
					<div id="licenceAllowContent">
					</div>
				</div>
				
				<div id="licenceDeny" style="display:none">
					<h4>This licence forbids:</h4>
					<div id="licenceDenyContent">
					</div>
				</div>
				
				<div id="licenceConditions" style="display:none">
					<h4>This licence has the following conditions:</h4>
					<div id="licenceConditionsContent">
					</div>
				</div>
				
				<h4>Read More</h4>
					<p>More information about this licence, including legal text, is available at:<br>
					<span id="licenceInfoURL">Unknown Location</span></p>
				</div>
			
				<p>
				';
		}
		else
		{
			echo '<div class="well">		
			<h4>No Licences Available</h4>
				<p>Unfortunately, as there are no enabled licences, file uploading is disabled.</p>
			</div>';		
		}
		?>
	</div>
	<div class="span4" id="upload_message_div" hidden>
		<div id="settings" class="well">
			<ol class="lead"><li>Choose your files to upload</li>
			<li>Confirm to start the upload</li>
			<li>Click back to upload files under a different licence or publicity</li></ol>
			<p><a href="#" class="btn" id="back_button"><i class = "icon-arrow-left"></i> Back</a></p>

		</div>
	</div>
	<div class="span8" id="upload_div" hidden>
		<iframe id="upload_frame" style="width:100%;border:none;height:400px;" src=""></iframe>
	</div>
</div>

<script>

	$('#next_button').click(function(){
	
	    $.getJSON('<?php echo base_url(); ?>project/{file_project}/upload_token', function(data) {
	    
	    	$('#settings_message_div').hide()
	    	$('#settings_div').hide()
	    	$('#upload_message_div').show();
	    	$('#upload_div').show();
	    	$('#upload_frame').attr('src','{orbital_core_location}fileupload/form?token=' + data.upload_token + '&licence=' + $('#licence').val() + '&public=' + $('#publicity').val());
	    	
	    });
	});
	
	$('#back_button').click(function(){
	
    	$('#settings_message_div').show()
    	$('#settings_div').show()
    	$('#upload_message_div').hide();
    	$('#upload_div').hide();
	});
    
    $.getJSON('<?php echo base_url(); ?>licence/' + $('#licence').val() + '/json', function(data) {

		if (data.allow !== null)
		{
			$('#licenceAllowContent').html(data.allow);
			$('#licenceAllow').show();
		}
		
		if (data.conditions !== null)
		{
			$('#licenceConditionsContent').html(data.conditions);
			$('#licenceConditions').show();
		}
		
		if (data.forbid !== null)
		{
			$('#licenceDenyContent').html(data.forbid);
			$('#licenceDeny').show();
		}
		
		$('#licenceInfoURL').html('<a href="' + data.summary_uri + '" target="_blank">' + data.summary_uri + '</a>');
		
	  
	});
	
	$('#licence').change(function(){
	
			
		$.getJSON('<?php echo base_url(); ?>licence/' + $('#licence').val() + '/json', function(data) {
		  
			if (data.allow !== null)
			{
				$('#licenceAllowContent').html(data.allow);
				$('#licenceAllow').show();
			}
			else
			{
				$('#licenceAllow').hide();
			}
			
			if (data.conditions !== null)
			{
				$('#licenceConditionsContent').html(data.conditions);
				$('#licenceConditions').show();
			}
			else
			{
				$('#licenceConditions').hide();
			}
			
			if (data.forbid !== null)
			{
				$('#licenceDenyContent').html(data.forbid);
				$('#licenceDeny').show();
			}
			else
			{
				$('#licenceDeny').hide();
			}
			
			$('#licenceInfoURL').html('<a href="' + data.summary_uri + '" target="_blank">' + data.summary_uri + '</a>');
		  
		});
	  
	});
  
</script>