<?php

/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

global $post;
$postID = $post->ID;

$posts = get_posts(array());

$Show_top_section = get_field("title", $postID);

?>

<?php
while (have_posts()) :
	the_post();
?>



	<main <?php post_class('site-main'); ?> role="main">
		<?php if (apply_filters('hello_elementor_page_title', true)) : ?>
			<header class="page-header">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			</header>
		<?php endif; ?>
		<div class="page-content">


			<?php
			// the_content();



			foreach ($posts as $_post) {

				echo '<div class="card col-3 m-2">';
				if (has_post_thumbnail($_post->ID)) {
					echo '<div class="card-img-top">' . get_the_post_thumbnail($_post->ID, 'full') . '</div>';
				}

				echo '<button data-bs-toggle="modal" data-bs-target="#myModal-' . ($_post->ID) . '" title="' . esc_attr($_post->post_title) . '" data-bs-toggle="modal">';
				echo '<h3>' . esc_attr($_post->post_title) . '</h3>';
				echo '</button>';
				echo '</div>';
			}
			echo '</div>';

			?>

			<div class="post-tags">
				<?php the_tags('<span class="tag-links">' . __('Tagged ', 'hello-elementor'), null, '</span>'); ?>
			</div>
			<?php wp_link_pages(); ?>
		</div>

		<?php comments_template(); ?>
	</main>

<?php
endwhile;
