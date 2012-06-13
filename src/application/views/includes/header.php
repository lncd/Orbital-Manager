<!DOCTYPE html>
<html lang="en">
	<head>
	
		<meta charset="utf-8">
		<title>{page_title} - {orbital_manager_name}</title>
		
		<!--[if lt IE 9]>
		<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Le styles -->
		<link href="{base_url}css/bootstrap.min.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
			.sidebar-nav {
				padding: 9px 0;
			}
		</style>
		<link href="{base_url}css/bootstrap-responsive.min.css" rel="stylesheet">
		<link href="{base_url}css/jquery-ui.css" rel="stylesheet">
		<link href="{base_url}css/font-awesome.css" rel="stylesheet">
		
		<link href="{base_url}css/orbital.css" rel="stylesheet">
		
		<link rel="shortcut icon" href="{base_url}favicon.ico">
		<link rel="apple-touch-icon" href="{base_url}img/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="{base_url}img/apple-touch-icon-72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="{base_url}img/apple-touch-icon-114.png">
		
		<script src="{base_url}js/jquery.min.js"></script>
		<script src="{base_url}js/bootstrap.min.js"></script>
		<script src="{base_url}js/jquery-ui.min.js"></script>
		<script src="{base_url}js/jquery.iframe-transport.js"></script>
		<script src="{base_url}js/jquery.fileupload.js"></script>
		
		<script type="text/javascript">
		
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17360674-21']);
		_gaq.push(['_trackPageview']);
		
		<?php
		
		if (isset($alt_tracking))
		{
			echo '_gaq.push([\'b.setAccount\', \'' . $alt_tracking . '\']);
			_gaq.push([\'b._trackPageview\']);

			function recordDownload(link, action)
			{
				try 
				{
					var pageTracker=_gat._getTracker("' . $alt_tracking . '");
					pageTracker._trackEvent(\'Download File\', action);
					setTimeout(\'document.location = "\' + link.href + \'"\', 100);
					return false;
				}
				catch(err)
				{}
			}';

		}
		else
		{
			echo 'function recordDownload(link, action)
			{}';

		}
		
		?>
		
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		
		</script>
	
	</head>
	
	<body>
	
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</a>
					<a class="brand" href="{base_url}">{orbital_manager_name}</a>
					<div class="nav-collapse">
						<ul class="nav">
							<li><a href="{base_url}">Home</a></li>
							{nav_menu}
								<li><a href="{uri}">{name}</a></li>
							{/nav_menu}
							<li class="dropdown">
							    <a href="#"
							          class="dropdown-toggle"
							          data-toggle="dropdown">
							          Tools
							          <b class="caret"></b>
							    </a>
							    <ul class="dropdown-menu">
									<li><a href="{base_url}planner">Project Planner</a></li>
									<li><a href="{base_url}policy">Policy &amp; Guidance</a></li>
							    </ul>
							</li>
							<li class="dropdown">
							    <a href="#"
							          class="dropdown-toggle"
							          data-toggle="dropdown">
							          About
							          <b class="caret"></b>
							    </a>
							    <ul class="dropdown-menu">
									<li><a href="{base_url}about">About Orbital</a></li>
									<li><a href="{base_url}contact">Contact Details</a></li>
									<li><a href="{base_url}changelog">Change Log</a></li>
							    </ul>
							</li>
						</ul>
						<p class="navbar-text pull-right">{user_presence}</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
		<?php 
		if ($this->session->flashdata('message'))
		{
			$message = $this->session->flashdata('message');
			
			if($this->session->flashdata('message_type'))
			{
				$message_type = $this->session->flashdata('message_type');
			}
		}
		
		if (isset($message))
		{
			echo '<div class="alert'; 
			
			if(isset($message_type))
			{
				echo ' alert-' . $message_type;
			}
			
			echo '"><a class="close" data-dismiss="alert">×</a>' . $message . '</div>';
		}
		?>