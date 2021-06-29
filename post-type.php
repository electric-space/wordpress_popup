<?php 

// Register Custom Post Type

function custom_post_type() {

	$txtdomain = 'maharishi';


    /**
	 * Popup
	 */
	$labels = array(
		'menu_name' => __( 'Popups', $txtdomain ),
	);

	$args = array(
		'label'        => __( 'Popups', $txtdomain ),
		'public'       => true,
		'has_archive'  => true,
		'supports'     => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'page-attributes'),
		'rewrite'      => array('slug' => 'popup'),
		'has_archive'  => false,
		'hierarchical' => true,
	);

	register_post_type( 'popups_cpt', $args );
	
	
	
	
}

add_action( 'init', 'custom_post_type', 0 );