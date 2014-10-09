<table>
	<tr><td>Link URL:</td><td><input name="recommend-link-url" value="<?php echo esc_url(get_post_meta(get_the_ID(), 'recommend-link-url', true ))?>" type="text"/></td>
	<tr><td>Site Name:</td><td><input name="recommend-site-name" value="<?php echo get_post_meta(get_the_ID(), 'recommend-site-name', true )?>" type="text"/></td>
	<?php wp_nonce_field('recommendation-link-update','recommendation-link-nonce')?>
</table>