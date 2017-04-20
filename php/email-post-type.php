<?php
 /*
 *
 *  Email Custom Post Type
 *
 */

 // Register Custom Post Type
function mylccc_email() {

	$labels = array(
		'name'                  => _x( 'Emails', 'Post Type General Name', 'mylccc' ),
		'singular_name'         => _x( 'Email', 'Post Type Singular Name', 'mylccc' ),
		'menu_name'             => __( 'MyLCCC Emailer', 'mylccc' ),
		'name_admin_bar'        => __( 'MyLCCC Emailer', 'mylccc' ),
		'archives'              => __( 'Daily Emailer Archives', 'mylccc' ),
		'parent_item_colon'     => __( 'Parent Email:', 'mylccc' ),
		'all_items'             => __( 'All Daily Emails', 'mylccc' ),
		'add_new_item'          => __( 'Add New Emailer', 'mylccc' ),
		'add_new'               => __( 'Add New', 'mylccc' ),
		'new_item'              => __( 'New Emailer', 'mylccc' ),
		'edit_item'             => __( 'Edit Emailer', 'mylccc' ),
		'update_item'           => __( 'Update Emailer', 'mylccc' ),
		'view_item'             => __( 'View Emailer', 'mylccc' ),
		'search_items'          => __( 'Search Emailer', 'mylccc' ),
		'not_found'             => __( 'Not found', 'mylccc' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'mylccc' ),
		'featured_image'        => __( 'Featured Image', 'mylccc' ),
		'set_featured_image'    => __( 'Set featured image', 'mylccc' ),
		'remove_featured_image' => __( 'Remove featured image', 'mylccc' ),
		'use_featured_image'    => __( 'Use as featured image', 'mylccc' ),
		'insert_into_item'      => __( 'Insert into Emailer', 'mylccc' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Emailer', 'mylccc' ),
		'items_list'            => __( 'Emailer list', 'mylccc' ),
		'items_list_navigation' => __( 'Emailer list navigation', 'mylccc' ),
		'filter_items_list'     => __( 'Filter items Emailer', 'mylccc' ),
	);
	$args = array(
		'label'                 => __( 'Email', 'mylccc' ),
		'description'           => __( 'Daily Email Post', 'mylccc' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'custom-fields', 'post-formats', ),
		'taxonomies'            => array( 'category', ' post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-email-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		
	);
	register_post_type( 'mylccc_email', $args );

 }
 add_action( 'init', 'mylccc_email', 0 );


?>