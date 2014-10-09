<?php
/**
 * The Template for displaying single recommendations. Likely won't be reached directly, but just in case...
 *
 * @package Gameteller
 * 
 */

get_header();
?>
 <div class="feed col-xs-12 col-sm-9 col-sm-height col-md-height col-lg-height full-height">
	<div class="row nopadding full-height">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="col-xs-12 nopadding full-height">
			<article class="article row">
		    	<div class="article-hero col-xs-12 nopadding">
		        	<div class="article-genre <?php echo get_color_for_category(get_the_category()[0]->term_id)?>"><h3><?php echo get_the_category()[0]->name?></h3></div>
		        		<div class="hero-img" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id() );?>')"></div>
		        		<div class="article-hero-info row nopadding">
		        			<div class="col-xs-6 photo-credits nopadding">
		        				Photo source: <a href="<?php echo esc_url(get_post_meta(get_the_ID(), 'img-src-link-url', true ))?>"><?php echo esc_html(get_post_meta(get_the_ID(), 'img-src-name', true ))?></a>
		        			</div>
		        			<div class="col-xs-6 sharebuttons nopadding">
		        				Share This: 
		        				<ul>
			        				<li><a rel="external nofollow" href="<?php echo $gt_plugin->generate_facebook_url(get_the_ID());?>" target="_blank"><span class="shareicon fa fa-facebook-square fa-2x"></a></span></li>
			                        <li><a rel="external nofollow" href="<?php echo $gt_plugin->generate_twitter_url(get_the_ID(),'Via @SuperStorycraft: ');?>" target="_blank"><span class="shareicon fa fa-twitter-square fa-2x"></a></span></li>
			                        <li><a rel="external nofollow" href="<?php echo $gt_plugin->generate_tumblr_url(get_the_ID());?>" target="_blank"><span class="shareicon fa fa-tumblr-square fa-2x"></span></a></li>
		                        </ul>
		        			</div>
		        		</div>
		        	</div>
		        	<div class="article-header col-xs-12 nopadding">		        		
		        		<h1><?php the_title()?></h1>
		        		<span class="article-credits">Shared by <a href="localhost"><?php the_author()?></a> on <?php the_time( get_option( 'date_format' ) )?></span>
		        		<hr>
		        	</div>
		        	<div class="article-content col-xs-12 nopadding">
		        		<?php the_content()?>
		        		<a href="<?php echo esc_url(get_post_meta($post->ID,'recommend-link-url',true))?>" target="_blank"><span class="read-more">READ MORE >></span></a>  		
		        	</div>
		        	<div class="sharelinks">
		        		SHARE THIS: <a rel="external nofollow" href="<?php echo $gt_plugin->generate_facebook_url(get_the_ID());?>" target="_blank"><span class="shareicon fa fa-facebook-square fa-2x"></span> Facebook</a>
		        					<a rel="external nofollow" href="<?php echo $gt_plugin->generate_twitter_url(get_the_ID(),'Via @SuperStorycraft: ');?>" target="_blank"><span class="shareicon fa fa-twitter-square fa-2x"></span> Twitter</a>
		        					<a rel="external nofollow" href="<?php echo $gt_plugin->generate_tumblr_url(get_the_ID());?>" target="_blank"><span class="shareicon fa fa-tumblr-square fa-2x"></span> Tumblr</a>
		        	</div>	
			</article>
		</div>
	<?php endwhile;?>
	</div>
</div>
<?php
get_footer();
?>?>