<?php get_header(); ?>
<div class="feed col-xs-12 col-sm-9 col-sm-height col-md-height col-lg-height">	
	<div class="row nopadding">
	<?php
		if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();
						get_template_part( 'index-content', get_post_type() );
					endwhile;
				endif;
			?>
	</div>
	<div class="row page-links">
		<div class="alignright nopadding pagination">
			<?php echo get_previous_posts_link( '<span class="fa fa-chevron-left"></span> NEWER' ); ?>
		</div>
		<div class="nopadding aligncenter" style="display: inline-block; width: 5%">
			<span class="fa fa-circle"></span>
		</div>
		<div class="alignleft nopadding pagination">
			<?php echo get_next_posts_link('OLDER <span class="fa fa-chevron-right"></span>'); ?>
		</div>
	</div>
</div>

<?php get_footer()?>