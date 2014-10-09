<!DOCTYPE html>
<html lang="en" class="full-height">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php echo wp_title(); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body class="full-height">
	<div id ="content" class="full-height">
		<div class="container-fluid nopadding container-sm-height container-md-height container-lg-height full-height">
			<div class="row row-sm-height row-md-height row-lg-height nopadding full-height">
			    <header class="col-xs-12 col-sm-3 header-padding col-sm-height col-md-height col-lg-height col-top drop-shadow">
			        <div class="logobar">
			        	<a href="<?php echo home_url()?>">
				        	<div class="logo">
				            	<img src="<?php echo get_template_directory_uri()?>/img/storycraft-wii-logo.svg" alt="Gameteller?>"/>
				            </div>
			            </a>
			           	<div class="tagline">
			        		Not your parents' video game and interactive storytelling blog.
			        	</div>
			        </div>
				   	<div class="side-menu-box hidden-xs">
				   		<div class="sidenav">
							<?php wp_nav_menu( array( 'theme_location' => 'category-menu', 'container_class' => 'category-menu' ) ); ?>
				    	</div>
				    	<div class="contact-info">
				    		<p>Want us to cover a project, make a correction, or just want to shower us with praise?</p>
				    		<p>Email us:<br><a href="mailto:contact@superstorycraft.com" class="nopadding">contact@superstorycraft.com</a></p>
				    	</div>
				    </div>
			    </header>
	    