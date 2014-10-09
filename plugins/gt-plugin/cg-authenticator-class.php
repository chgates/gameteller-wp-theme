<?php
/* CLASS: CG_Authenticator_Class
 * AUTHOR: Christopher Gates
 * DESCRIPTION: Helper class; contains code for verifying security, filtering input, and ultimately saving meta-box and custom field information.
 * CREDIT WHERE IT'S DUE: Inspired by Tom McFarlin and his WordPress Meta-Box Simplification articles (https://tommcfarlin.com/wordpress-meta-boxes-each-component/)
*/


class CG_Authenticator_Class
{
	private $fields_to_update;
	private $sanitization_options;
	private $nonce;
	private $action;
	private $nonce_action;
	
	public function __construct($fields_to_update, $sanitization_options, $nonce, $nonce_action, $action)
	{
		$this->fields_to_update = $fields_to_update;
		$this->nonce = $nonce;
		$this->action = $action;
		$this->nonce_action = $nonce_action;
		$this->sanitization_options = $sanitization_options;
	}
	
	public function save_fields($post_id)
	{
		if( $this->user_can_save( $post_id )) 
		{
			for ($i = 0; $i < sizeof($this->fields_to_update); $i++)
			{				
				$field = $this->fields_to_update[$i];
				if ( isset( $_POST[$field] ) ) 
				{
					$input = $_POST[$field];
					if (sizeof($this->fields_to_update) == sizeof($this->sanitization_options))
					{
						$input = $this->sanitization_options[$i]($input);
					}
					update_post_meta( $post_id, $field, $input);
				} 
				else 
				{
					delete_post_meta( $post_id, $field );
				}
			}
		
		}
	}
	
	public function user_can_save( $post_id )
	{	
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ $this->nonce ] ) && wp_verify_nonce($_POST[ $this->nonce ], $this->nonce_action ) );
		$user_can = current_user_can( $this->action, $post_id );
	
		return !( $is_autosave || $is_revision ) && $is_valid_nonce && $user_can;
	}
}
?>