<?php

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

// Remove this action and callback function if you are not adding CSS in the style.css file.
add_action( 'wp_enqueue_scripts', 'beans_child_enqueue_assets' );

function beans_child_enqueue_assets() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

}

// Remove post author meta
add_filter( 'beans_post_meta_items', 'beans_child_remove_post_meta_items' );

function beans_child_remove_post_meta_items( $items ) {
    unset( $items['author'] );
    return $items;
}

// Modify left footer text
add_filter( 'beans_footer_credit_text_output', 'modify_left_copyright' );
function modify_left_copyright() {
     return '© 2016 - John Cosio. All rights reserved, Built with <a href="http://www.getbeans.io">Beans</a>';
}

// Add a custom menu location for footer right
function register_footer_menu() {
  register_nav_menu('footer-menu',__( 'Footer Right Menu' ));
}
add_action( 'init', 'register_footer_menu' );

// Modify right footer text
add_filter( 'beans_footer_credit_right_text_output', 'modify_right_copyright' );
function modify_right_copyright() {
    //echo beans_output( 'beans_primary_menu', wp_nav_menu( $args ) );
	wp_nav_menu( array( 'theme_location' => 'footer-menu' ) );
}

// Display excerpt instead of full posts
add_filter( 'the_content', 'beans_child_modify_post_content' );

function beans_child_modify_post_content( $content ) {

    // Stop here if we are on a single view.
    if ( is_singular() )
        return $content;

    // Return the excerpt() if it exists other truncate.
    if ( has_excerpt() )
        $content = '<p>' . get_the_excerpt() . '</p>';
    else
        $content = '<p>' . wp_trim_words( get_the_content(), 40, '...' ) . '</p>';

    // Return content and readmore.
    return $content . '<p>' . beans_post_more_link() . '</p>';

}