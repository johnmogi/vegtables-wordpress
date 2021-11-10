<?php

/**
 * Template Name: Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
global $post;
$postID = $post->ID;

$posts = get_posts(array());

$Show_top_section = get_field("title", $postID);




?>
<div class="row" />
<?php
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

foreach ($posts as $_post) {
  $title =  get_field("title", $_post->ID);
  echo '<div id="myModal-' . ($_post->ID) .  '" class="modal right fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >';
  echo ' <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
        ' . esc_attr($_post->post_title) . '
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h4 class="font-Bold"> 
      ' . esc_attr($title) . '
       </h4>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </div>
  </div>';
}


wp_reset_query();



get_footer();
