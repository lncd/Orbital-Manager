<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<title>Orbital Manager</title>

	<link href='https://fonts.googleapis.com/css?family=Spinnaker' rel='stylesheet' type='text/css'>

	<style type="text/css">
	
		body {
			background: #000 url(<?php echo base_url(); ?>img/bg.png);
			color: #FFF;
			font-family: 'Spinnaker', sans-serif;
			text-align: center;
			font-size: 1.2em;
			margin-top: 50px;
		}
		
		a {
			color: #F5D89A;
		}
	
	</style>
	
</head>
<body>

	<h1><img src="<?php echo base_url(); ?>img/logo.png" title="Orbital" alt="Orbital Logo"></h1>
	
	<p>This is Orbital Manager version <?php echo $this->config->item('orbital_manager_version'); ?>. Orbital Core instance is at <?php echo $this->config->item('orbital_core_location'); ?>.
	
	<p><a href="https://github.com/lncd/Orbital-Manager">Orbital Manager on Github</a> &middot; <a href="http://orbital.blogs.lincoln.ac.uk/">Orbital Blog</a></p>

</body>
</html>