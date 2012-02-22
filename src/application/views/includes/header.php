<!DOCTYPE html>
<html lang="en">
	<head>
	
		<meta charset="utf-8">
		<title>{page_title} - {orbital_manager_name}</title>
		
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
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
		<link href="{base_url}css/bootstrap.min.responsive.css" rel="stylesheet">
		
		<link rel="shortcut icon" href="{base_url}favicon.ico">
		<link rel="apple-touch-icon" href="{base_url}img/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="{base_url}img/apple-touch-icon-72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="{base_url}img/apple-touch-icon-114.png">
		
	</head>
	
	<body>
	
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</a>
					<a class="brand" href="#">{orbital_manager_name}</a>
					<div class="nav-collapse">
						<ul class="nav">
							{nav_menu}
								<li><a href="{uri}">{name}</a></li>
							{/nav_menu}
							<li><a href="{base_url}">Home</a></li>
							<li><a href="{base_url}about">About</a></li>
							<li><a href="{base_url}contact">Contact</a></li>
						</ul>
						<p class="navbar-text pull-right">{user_presence}</p>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid">