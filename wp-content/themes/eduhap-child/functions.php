<?php

add_filter( 'rest_post_tag_collection_params', function ( $params ) {
    $params['per_page']['maximum'] = 500;
    return $params;
});


function eduhap_child_enqueue_styles() {

    $parent_style = 'parent-style';


    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
	
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	
}
add_action( 'wp_enqueue_scripts', 'eduhap_child_enqueue_styles' );



