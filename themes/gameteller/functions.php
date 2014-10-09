<?php

//Style-sheets, helper classes, etc.
if (!is_admin()) {

	// Load CSS
	add_action('wp_enqueue_scripts', 'gt_load_styles', 11);
	function gt_load_styles() 
	{
		// Bootstrap
		wp_register_style('bootstrap-styles', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', array(), null, 'all');
		wp_enqueue_style('bootstrap-styles');
		
		//Google Fonts
		wp_register_style('font-styles', 'http://fonts.googleapis.com/css?family=Roboto+Slab:400,700|Play:400,700', array(), null, 'all');
		wp_enqueue_style('font-styles');

		// Font Awesome
		wp_register_style('font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css', array(), null, 'all');
		wp_enqueue_style('font-awesome');
		
		// Theme Styles
		wp_register_style('theme-styles', get_stylesheet_uri(), array(), null, 'all');
		wp_enqueue_style('theme-styles');

	}

	// Load Javascript
	add_action('wp_enqueue_scripts', 'gt_load_scripts', 12);
	function gt_load_scripts() 
	{
		// jQuery
		wp_enqueue_script('jquery');
		
		// Bootstrap
		/*
		wp_register_script('bootstrap-scripts', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), null, false);
		wp_enqueue_script('bootstrap-scripts');
		*/
		//Custom code
		wp_register_script('gameteller-scripts', get_template_directory_uri().'/js/gameteller.js', array('jquery'),null, false);
		wp_enqueue_script('gameteller-scripts');
		
	}
	
	//Edit the loop
	add_filter( 'pre_get_posts', 'my_get_posts' );
	function my_get_posts( $query )
	{
	
		if ( $query->is_main_query() )
		{
			$query->set( 'post_type', array( 'post', 'recommendations' ));
			$query->set( 'posts_per_page', 8 );
		}
	
		return $query;
	}
	
} // end if !is_admin



//Support featured images, which is a big part of our design
add_theme_support('post-thumbnails');

// Menu hooks
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array
		(
			'header-menu' => __( 'Header Menu', 'gametellerdomain' ),
			'category-menu' => __( 'Category Menu', 'gametellerdomain' ),
			'footer-menu' => __('Footer Menu', 'gametellerdomain')
		)
	);
}


/* HELPER FUNCTIONS - FOR FORMATTING */

/**
 * Lifted directly from WP documentation
 */
function theme_name_wp_title( $title) {
	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $site_description";
	}

	return $title;
}
add_filter( 'wp_title', 'theme_name_wp_title');

function get_color_for_category($category)
{
	global $gt_plugin;
	
	$category = $gt_plugin->category_type($category);
	switch($category)
	{
		case 'news':
			return 'red';
		case 'features':
			return 'blue';
		case 'reviews':
			return 'yellow';
		case 'recommendations':
		default:
			return 'green';
	}
}

function get_index_box_size($post_number)
{
	if ($post_number == 0)
		return 'col-sm-12 col-md-7 featured'; 
	else if ($post_number == 1) 
		return 'col-sm-12 col-md-5 featured'; 
	else 
		return 'col-sm-6 col-md-4';
}

?>
