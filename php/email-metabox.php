<?php

	/*
		*	Code adapted from https://www.smashingmagazine.com/2011/10/create-custom-post-meta-boxes-wordpress
		*	Created May 2016.
		*
		*/

	/* Fire our meta box setup function on the post editor screen. */
	add_action( 'load-post.php', 'lc_emailer_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'lc_emailer_post_meta_boxes_setup' );


	/* Meta box setup function. */
	function lc_emailer_post_meta_boxes_setup(){
		/* Add meta boxes on the 'add_meta_boxes' hook. */
			add_action( 'add_meta_boxes', 'lc_emailer_add_meta_boxes' );

		/* Save post meta on the 'save_post' hook. */
			add_action( 'save_post', 'lc_emailer_save_email_date_post', 10, 2 );
	}



	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function lc_emailer_add_meta_boxes() {
		add_meta_box(
			'lc_emailer_post_date_metabox',																											// Unique ID (ID of Div Tag ** Note: DO NOT NAME same as field(s) below **)
			esc_html__( 'Date of Posts to Include', 'mylccc' ),														// Title & Text Domain
			'lc_emailer_post_date_meta_box',																		// Callback function
			'mylccc_email',																																			// Admin Page or Post Type
			'normal',																																											// Context (Position)
			'default'																																									//	Priority
		);
	}

	/* Display the post meta box */
	function lc_emailer_post_date_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'lc_emailer_post_date_nonce' ); ?>

	<script type="text/javascript">
	jQuery(document).ready(function() {
					jQuery('#lc_emailer_post_date_field').datepicker({
									dateFormat: "yy-mm-dd"
					});
	});
	</script>

	<p>
		<label for="lc_emailer_post_date_field"><?php _e( "Choose the date of the posts to include: ", "mylccc" ); ?></label>
		<input type="text" name="lc_emailer_post_date_field" id="lc_emailer_post_date_field" value="<?php echo esc_attr( get_post_meta( $object->ID, 'lc_emailer_post_date', true ) ); ?>" size="30" />
	</p>

<?php
	}

	/* Save the meta box's post metadata */
	function lc_emailer_save_email_date_post( $post_id, $post ) {

		/* Verify the nonce before proceeding */
		if ( !isset( $_POST['lc_emailer_post_date_nonce'] ) || !wp_verify_nonce( $_POST['lc_emailer_post_date_nonce'], basename( __FILE__ ) ) )
			return $post_id;

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;

		/* Get the posted data and sanitize it for use as a date value. */
		$new_meta_value = ( isset( $_POST['lc_emailer_post_date_field'] ) ? sanitize_text_field($_POST['lc_emailer_post_date_field'] ) : '' );

		/* Get the meta key. */
		$meta_key = 'lc_emailer_post_date';

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );
	}


?>