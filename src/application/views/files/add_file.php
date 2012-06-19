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
	<div class="span6">
		<div class="well" id="settings_div">
		<?php
		$form_public = array(
				'name'		=> 'public',
				'id'		=> 'file_public',
				'value'		=> 'public',
				'checked'	=> set_checkbox('public', 'public', 0)
			);
		
		if (isset($file_licences) AND count($file_licences) > 0)
		{
			foreach ($file_licences as $licence)
			{
				$available_licences[$licence->id] = $licence->name;
			}
				
			echo form_label('Make these files publicly available?', 'public');
			echo form_checkbox($form_public);
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
				<a href="#" class="btn btn-primary" id="next_button"><i class = "icon-arrow-right"></i> Next</a></p>
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
	</div>
	<div class="span6">
		<div class="well" id="upload_div" hidden>
			<iframe id="upload_frame" style="width:100%;border:none;height:400px;" src=""></iframe>
		</div>
	</div>
	<div class="span6" id="settings_message_div">
		<div id="settings" class="well">
			SETTINGS
		</div>
	</div>
</div>

<script>

	$('#next_button').click(function(){
	
	    $.getJSON('<?php echo base_url(); ?>project/{file_project}/upload_token', function(data) {
	    
	    	$('#settings_message_div').hide()
	    	$('#upload_div').show();
	    	$('#upload_frame').attr('src','{orbital_core_location}fileupload/form?token=' + data.upload_token + '&licence=' + $('#licence').val() + '&public=' + $('#file_public').attr('checked'));
	    	
	    });
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