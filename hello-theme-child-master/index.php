<?php

/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header();


$args = array(
	'post_type' => 'vegtables',
	'post_status' => 'publish',
);
$loop = new WP_Query($args);

// while ($loop->have_posts()) : $loop->the_post();
// 	print the_title();
// 	the_excerpt();
// endwhile;







if (is_singular()) {
	if (!$is_elementor_theme_exist || !elementor_theme_do_location('single')) {
		get_template_part('template-parts/single');
	}
} elseif (is_archive() || is_home()) {
	if (!$is_elementor_theme_exist || !elementor_theme_do_location('archive')) {
		get_template_part('template-parts/archive');
	}
} elseif (is_search()) {
	if (!$is_elementor_theme_exist || !elementor_theme_do_location('archive')) {
		get_template_part('template-parts/search');
	}
} else {
	if (!$is_elementor_theme_exist || !elementor_theme_do_location('single')) {
		get_template_part('template-parts/404');
	}
}

wp_reset_postdata();


get_footer();
