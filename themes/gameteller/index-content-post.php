<article class="main-content col-xs-12 <?php echo get_index_box_size($wp_query->current_post) ?>">
	<div class="article-wrapper reveal-link">
    	<div class="feature" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() );?>)">
        </div>
        <div class="feature-info">
        	<div class="feature-background <?php echo get_color_for_category(get_the_category()[0]->term_id)?>-transparent">
        		<div class="feature-headline">
                	<h2><?php the_title()?></h2>
                	<span class="feature-date"><?php the_time( get_option( 'date_format' ) )?></span>
                </div>
            </div>
         </div>           
		 	<a class="front-page-link" href="<?php the_permalink()?>">
		     	<link>
		        	<h2 class="underline-on-hover"><?php the_title();?></h2>
		         </link>                           
		         <div class="summary">
		         	<?php the_excerpt();?>
		            <span class="read-more underline-on-hover">READ MORE >></span>
		        </div>
		    </a>
	    	
	</div>
</article>