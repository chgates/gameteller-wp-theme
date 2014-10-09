<?php
/*
 Plugin Name: GameTeller Theme Plug-in
Plugin URI: http://www.gameteller.com
Description: Plug-in for GameTeller.com (non-display options)
Version: .1
Author: Chris Gates
Author URI: http://www.christhewriter.com
License: GPL2
*/

if(!class_exists('CG_Authenticator_Class'))
{
	include_once 'cg-authenticator-class.php';
}

$gt_plugin = new Gameteller_Plugin();
class Gameteller_Plugin
{

	private $categories = array();
	private $recommendation_metabox_handler;
	private $img_src_metabox_handler;
	
	public function __construct()
	{
		add_action( 'after_setup_theme', array( $this, 'create_gt_categories' ) );
		add_action( 'after_setup_theme', array( $this, 'create_gt_posttypes' ) );
		
		add_action( 'save_post_recommendations', array( $this, 'save_recommendations' ) );
		
		$this->recommendation_metabox_handler = new CG_Authenticator_Class(array('recommend-link-url','recommend-site-name'), array('sanitize_text_field','sanitize_text_field'), 'recommendation-link-nonce', 
									'recommendation-link-update', 'edit_posts');
		
		add_action( 'add_meta_boxes', array($this,'add_img_src_metabox') );
		add_action( 'save_post', array( $this, 'save_img_src' ) );
		
		
		$this->img_src_metabox_handler = new CG_Authenticator_Class(array('img-src-link-url','img-src-name'), array('sanitize_text_field','sanitize_text_field'), 'img-src-link-nonce',
				'img-src-link-update', 'edit_posts');
			
	}
	
	public function create_gt_categories()
	{
		
		$this->categories[ $this->get_or_create_category_id( 'News', 'news', 'News' ) ] = 'news';
		$this->categories[ $this->get_or_create_category_id( 'Reviews', 'reviews', 'Reviews' ) ] = 'reviews';
		$this->categories[ $this->get_or_create_category_id( 'Features', 'features', 'Features and Editorials' ) ] = 'features';
		$this->categories[ $this->get_or_create_category_id( 'Recommendations', 'recommended','Good Reads' ) ] = 'recommendations';
	}
	
	public function create_gt_posttypes()
	{
		//Set up Recommendation Posts
		$labels = array(
			'name' => __('Recommendations','gametellerdomain'),
			'singular_name' => __('Recommendation','gametellerdomain'),
			'menu_name' => __('Recommendations','gametellerdomain'),
			'parent_item_colon' => __('Parent Recommendation','gametellerdomain'),
			'all_items' => __('All Recommendations','gametellerdomain'),
			'view_item' => __('View Recommendation','gametellerdomain'),
			'add_new_item' => __('Add New Recommendation','gametellerdomain'),
			'add_new' => __('Add New','gametellerdomain'),
			'edit_item' => __('Edit Recommendation','gametellerdomain'),
			'update_item' => __('Update Recommendation','gametellerdomain'),
			'search_item' => __('Search Recommendations', 'gametellerdomain')
		);
		
		$args = array(
			'label' => __('recommendations','gametellerdomain'),
			'description' => __('Recommended content on external sites','gametellerdomain'),
			'labels' => $labels,
			'supports' => array('title','editor','thumbnail'),
			'hierarchical'        => false,
			'taxonomies' => array('category'),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite' => array('slug'=> __('recommendations','gametellerdomain')),
			'register_meta_box_cb' => array($this,'add_recommendation_metabox')
		);

		register_post_type('recommendations',$args);
	}
	
	public function add_recommendation_metabox()
	{
		add_meta_box('gt_recommendation_data', __('Recommendation Data','gametellerdomain'), array($this,'render_gt_recommendation_box'),'recommendations','normal','default');
	}
	
	public function render_gt_recommendation_box()
	{
		include_once 'gt_recommendation_box_display.php';
	}
	
	public function save_recommendations($post_id)
	{
		//Authentication...
		if (!($this->recommendation_metabox_handler->user_can_save($post_id)))
			return;
		
		$recommendation_category = $this->category_id('recommendations');
		if ((int)$recommendation_category > -1)
		{		
			$results = wp_set_post_categories( $post_id, $recommendation_category);
		}
		
		$this->recommendation_metabox_handler->save_fields($post_id);
		$this->save_img_src($post_id);

	}
	
	public function add_img_src_metabox($post_type)
	{
		add_meta_box('gt_img_src_data', __('Featured Image Source','gametellerdomain'), array($this,'render_img_src_box'),$post_type,'normal','default');
	}

	public function render_img_src_box()
	{
		include_once 'gt_img_src_box_display.php';
	}
	
	public function save_img_src($post_id)
	{
		$this->img_src_metabox_handler->save_fields($post_id);
	}

	public function category_type($id)
	{
		return $this->categories[$id];
	}
	
	public function category_id($type)
	{
		foreach ($this->categories as $key => $category)
		{
			if ($category == $type)
				return $key;
		}
		return -1;
	}
	
	public function generate_facebook_url($post_id)
	{
		$root = 'http://www.facebook.com/sharer/sharer.php?u=';
		$root .= get_permalink($post_id);
		return $root;
	}
	
	public function generate_twitter_url($post_id, $prepend)
	{
		global $Shortn_It;
		
		//Prepare title...
		$short_url = $Shortn_It->get_shortn_it_url_permalink( $post_id );
		$title = esc_html(wp_strip_all_tags(get_the_title($post_id)));
		$length = strlen($short_url)+strlen($prepend);
		
		if (strlen($title) > 140-$length-1)
		{
			$title = substr($title, 0, 140-$length-4);
			$title .= '...';
		}
		
		global $Shortn_It;
		$root = 'http://twitter.com/intent/tweet?text=';
		$root .= $prepend;
		$root .= urlencode($title);
		$root .= ' ';
		$root .= $short_url;
		return $root;
	}
	
	public function generate_tumblr_url($post_id)
	{
		$root = 'http://www.tumblr.com/share/link?url=';
		$root .= urlencode(get_permalink($post_id));
		$root .= '&name=';
		$root .= urlencode(wp_strip_all_tags(get_the_title($post_id)));
		$root .= '&description=';
		$root .= urlencode(get_post_field('post_excerpt', $post_id));
		return $root;
	}
	
	private function get_or_create_category_id($category, $slug, $description)
	{
		$id = get_term_by('name', $category, 'category');
		if (!$id)
		{
			$id = wp_insert_term($category,'category', array('description' => $description, 'slug' => $slug));
			$id = $id['term_id'];
		}
		else
		{
			$id = (int)$id->term_id;
		}
		
		//Typecasting in the case that the category already exists (id returned as string)
		return $id;
	}
}

?>