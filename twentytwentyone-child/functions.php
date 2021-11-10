<?php
add_action('wp_enqueue_scripts', 'twentytwentyone_child_enqueue_styles');
function twentytwentyone_child_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_stylesheet_directory_uri() . '/bootstrap.min.css');
} 
		   
		   
		//    function wpdocs_theme_name_scripts() {
		// 	   wp_enqueue_style( 'style-name', get_stylesheet_uri() );
		// 	//    wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
		// 	}
		// 	add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );
