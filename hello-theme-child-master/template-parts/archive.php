<?php

/**
 * The template for displaying archive pages.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
// distinguish parent and children...
?>
<div class="container">

	<main <?php post_class('site-main'); ?> role="main">
		<?php if (apply_filters('hello_elementor_page_title', true)) : ?>
			<header class="page-header">
				<?php single_term_title('<h1 class="entry-title">', '</h1>'); ?>
			</header>
		<?php endif; ?>
		<div class="page-content">

			<?php the_content(); ?>

			<?php

			$term = get_queried_object();

			$children = get_terms($term->taxonomy, array(
				'parent'    => $term->term_id,
				'hide_empty' => false,

			));



			if ($children) {
				foreach ($children as $subcat) {

					echo '<li><a href="' . esc_url(get_term_link($subcat, $subcat->taxonomy)) . '">' . $subcat->name . '</a></li>';
				}
			}

			?>
			<div class="page-content row">
				<?php
				while (have_posts()) {
					the_post();
					$post_link = get_permalink();
				?>
					<article class="post card col">
						<?php
						printf('<h2 class="%s"><a href="%s">%s</a></h2>', 'entry-title', esc_url($post_link), esc_html(get_the_title()));
						printf('<a href="%s">%s</a>', esc_url($post_link), get_the_post_thumbnail($post, 'large'));
						the_excerpt();
						?>
					</article>
				<?php } ?>
			</div>



		</div>

	</main>
</div>