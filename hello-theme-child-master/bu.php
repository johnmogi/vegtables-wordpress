<?php



/**

 *

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



global $post;

$postID = $post->ID;

$posts = get_posts(array());

$Show_top_section = get_field("title", $postID);





?>


<main <?php post_class('site-main'); ?> role="main">
	<?php if (apply_filters('hello_elementor_page_title', true)) : ?>
		<header class="page-header">
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		</header>
	<?php endif; ?>
	<div class="page-content">


		<?php
		echo 'inner page';
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



	</div>

</main>



<?php



wp_reset_query();

get_footer();
