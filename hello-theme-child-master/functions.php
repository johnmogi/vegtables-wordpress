<?php

/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts()
{
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action('wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20);


function prefix_create_custom_post_type()
{
	/*
     * The $labels describes how the post type appears.
     */
	$labels = array(
		'name'          => 'vegetables', // Plural name
		'singular_name' => 'vegetable'   // Singular name
	);

	/*
     * The $supports parameter describes what the post type supports
     */
	$supports = array(
		'title',        // Post title
		'editor',       // Post content
		'excerpt',      // Allows short description
		'author',       // Allows showing and choosing author
		'thumbnail',    // Allows feature images
		'comments',     // Enables comments
		'trackbacks',   // Supports trackbacks
		'revisions',    // Shows autosaved version of the posts
		'custom-fields' // Supports by custom fields
	);

	/*
     * The $args parameter holds important parameters for the custom post type
     */
	$args = array(
		'labels'              => $labels,
		'description'         => 'Post type post vegetable', // Description
		'supports'            => $supports,
		'taxonomies'          => array('category', 'post_tag'), // Allowed taxonomies
		'hierarchical'        => false, // Allows hierarchical categorization, if set to false, the Custom Post Type will behave like Post, else it will behave like Page
		'public'              => true,  // Makes the post type public
		'show_ui'             => true,  // Displays an interface for this post type
		'show_in_menu'        => true,  // Displays in the Admin Menu (the left panel)
		'show_in_nav_menus'   => true,  // Displays in Appearance -> Menus
		'show_in_admin_bar'   => true,  // Displays in the black admin bar
		'menu_position'       => 5,     // The position number in the left menu
		'menu_icon'           => true,  // The URL for the icon used for this post type
		'can_export'          => true,  // Allows content export using Tools -> Export
		'has_archive'         => true,  // Enables post type archive (by month, date, or year)
		'exclude_from_search' => false, // Excludes posts of this type in the front-end search result page if set to true, include them if set to false
		'publicly_queryable'  => true,  // Allows queries to be performed on the front-end part if set to true
		'capability_type'     => 'post' // Allows read, edit, delete like “Post”
	);

	register_post_type('vegetable', $args); //Create a post type with the slug is ‘product’ and arguments in $args.
}
add_action('init', 'prefix_create_custom_post_type');

// add bs4 support
function my_scripts()
{
	wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
	wp_enqueue_script('boot1', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array('jquery'), '', true);
	wp_enqueue_script('boot2', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'), '', true);
	wp_enqueue_script('boot3', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'my_scripts');


/**
 * add images to cats
 **/
if (!class_exists('CT_TAX_META')) {

	class CT_TAX_META
	{

		public function __construct()
		{
			//
		}

		/*
	  * Initialize the class and start calling our hooks and filters
	  * @since 1.0.0
	 */
		public function init()
		{
			add_action('category_add_form_fields', array($this, 'add_category_image'), 10, 2);
			add_action('created_category', array($this, 'save_category_image'), 10, 2);
			add_action('category_edit_form_fields', array($this, 'update_category_image'), 10, 2);
			add_action('edited_category', array($this, 'updated_category_image'), 10, 2);
			add_action('admin_enqueue_scripts', array($this, 'load_media'));
			add_action('admin_footer', array($this, 'add_script'));
		}

		public function load_media()
		{
			wp_enqueue_media();
		}

		/*
	  * Add a form field in the new category page
	  * @since 1.0.0
	 */
		public function add_category_image($taxonomy)
		{ ?>
			<div class="form-field term-group">
				<label for="category-image-id"><?php _e('Image', 'hero-theme'); ?></label>
				<input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
				<div id="category-image-wrapper"></div>
				<p>
					<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'hero-theme'); ?>" />
					<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'hero-theme'); ?>" />
				</p>
			</div>
		<?php
		}

		/*
	  * Save the form field
	  * @since 1.0.0
	 */
		public function save_category_image($term_id, $tt_id)
		{
			if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
				$image = $_POST['category-image-id'];
				add_term_meta($term_id, 'category-image-id', $image, true);
			}
		}

		/*
	  * Edit the form field
	  * @since 1.0.0
	 */
		public function update_category_image($term, $taxonomy)
		{ ?>
			<tr class="form-field term-group-wrap">
				<th scope="row">
					<label for="category-image-id"><?php _e('Image', 'hero-theme'); ?></label>
				</th>
				<td>
					<?php $image_id = get_term_meta($term->term_id, 'category-image-id', true); ?>
					<input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
					<div id="category-image-wrapper">
						<?php if ($image_id) { ?>
							<?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
						<?php } ?>
					</div>
					<p>
						<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'hero-theme'); ?>" />
						<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'hero-theme'); ?>" />
					</p>
				</td>
			</tr>
		<?php
		}

		/*
	 * Update the form field value
	 * @since 1.0.0
	 */
		public function updated_category_image($term_id, $tt_id)
		{
			if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
				$image = $_POST['category-image-id'];
				update_term_meta($term_id, 'category-image-id', $image);
			} else {
				update_term_meta($term_id, 'category-image-id', '');
			}
		}

		/*
	 * Add script
	 * @since 1.0.0
	 */
		public function add_script()
		{ ?>
			<script>
				jQuery(document).ready(function($) {
					function ct_media_upload(button_class) {
						var _custom_media = true,
							_orig_send_attachment = wp.media.editor.send.attachment;
						$('body').on('click', button_class, function(e) {
							var button_id = '#' + $(this).attr('id');
							var send_attachment_bkp = wp.media.editor.send.attachment;
							var button = $(button_id);
							_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment) {
								if (_custom_media) {
									$('#category-image-id').val(attachment.id);
									$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
									$('#category-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
								} else {
									return _orig_send_attachment.apply(button_id, [props, attachment]);
								}
							}
							wp.media.editor.open(button);
							return false;
						});
					}
					ct_media_upload('.ct_tax_media_button.button');
					$('body').on('click', '.ct_tax_media_remove', function() {
						$('#category-image-id').val('');
						$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
					});
					// Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
					$(document).ajaxComplete(function(event, xhr, settings) {
						var queryStringArr = settings.data.split('&');
						if ($.inArray('action=add-tag', queryStringArr) !== -1) {
							var xml = xhr.responseXML;
							$response = $(xml).find('term_id').text();
							if ($response != "") {
								// Clear the thumb image
								$('#category-image-wrapper').html('');
							}
						}
					});
				});
			</script>
<?php }
	}

	$CT_TAX_META = new CT_TAX_META();
	$CT_TAX_META->init();
}
