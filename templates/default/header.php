<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page['title'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS -->
  	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,600,300' rel='stylesheet' type='text/css'> 
  	<link href='<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/css/chosen.css' rel='stylesheet' type="text/css">
	<link href="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/css/paste.css" rel="stylesheet" type="text/css">
	<style type="text/css"> body { padding-top: 100px; } </style>
	<link href="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/css/bootstrap-responsive.css" rel="stylesheet">
	<?php
	if (isset($page['post']['codecss'])) { 
		echo '<style type="text/css">'."\n";
		echo $page['post']['codecss'];
		echo '</style>'."\n";}
	?>
	
	<!-- JS -->
	<script src="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/js/jquery/jquery-1.9.1-min.js"></script> 
	<script src="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/js/jquery/jquery.jpanelmenu.min.js"></script>
	<script src="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/js/jquery/jquery.cookie.js"></script>

	<!-- IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/img/favicon.ico">
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<!-- Responsive/Mobile menu button -->
				<a href="#">
					<button type="button" class="btn btn-navbar mobile-menu">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</a>
			<!-- Logo -->
			<a class="brand" href="<?php echo $CONF['url']?>"><img src="<?php echo $CONF['url'] . 'templates/' . $CONF['template']?>/img/logo.png"></a>
			<!-- User Navigation -->
		</div>
	</div>
</div>

<div class="container">
	<div class="navbar navbar-inverse" id="nav">
		<div class="navbar-inner">
			<ul class="nav">
				<li><a href="<?php echo $CONF['url'];?>"><i class="icon-paste"></i> Submit</a></li>
				<li><?php if ( $CONF['mod_rewrite'] == true ) { echo '<a href="'. $CONF['url'] .'search">'; } else { echo '<a href="'. $CONF['url'] .'search.php">'; } ?><i class="icon-search"></i> Search</a></li>
				<li><?php if ( $CONF['mod_rewrite'] == true ) { echo '<a href="'. $CONF['url'] .'archive">'; } else { echo '<a href="'. $CONF['url'] .'archive.php">'; } ?><i class="icon-archive"></i> Public Archive</a></li>
				<!-- who knows what we'll add here, docs? faq?
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-blah"></i> FAQ <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-blah"></i> Nothing to see here</a></li>
						</ul>
				</li> // -->

				<!-- we plan on adding image pastes too
				<li><a href="#"><i class="icon-picture"></i> Images</a></li>//-->

			</ul>
			
			<form action="search.php" method="POST" class="navbar-search pull-right">
				<input type="text" class="search-query typeahead" placeholder="Search">
			</form>
		</div>

	</div>