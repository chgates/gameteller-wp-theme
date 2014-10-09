<table>
	<tr><td>Image Source URL:</td><td><input name="img-src-link-url" value="<?php echo esc_url(get_post_meta(get_the_ID(), 'img-src-link-url', true ))?>" type="text"/></td>
	<tr><td>Site Name:</td><td><input name="img-src-name" value="<?php echo get_post_meta(get_the_ID(), 'img-src-name', true )?>" type="text"/></td>
	<?php wp_nonce_field('img-src-link-update','img-src-link-nonce')?>
</table>