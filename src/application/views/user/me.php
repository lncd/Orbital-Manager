<div class="row">
	<div class="span12">
	
		<ul class="breadcrumb">
			<li>
				<a href="{base_url}">Home</a> <span class="divider">/</span>
			</li>
			<li class="active">
				<a href="{base_url}me">My Profile</a></span>
			</li>
		</ul>
	
			<h1>{user_name} <small>{institution}</small></h1>		
		<!--
		
		<h2>Research Summary</h2>
		
		-->
		<h2>Access Token</h2>
		<?php
			echo $this->session->userdata('access_token') . '<br>'; 
			echo base64_encode($this->session->userdata('access_token'));
		?>
	</div>
</div>