<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package uds-wordpress-theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>


		<?php
		// get the thumbnail alt text.
		$thumbnail_id = get_post_thumbnail_id( $post->ID );
		$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
		?>
		<div class="col col-12 col-md-6 col-lg-4 mb-4">

		        <div class="card card-story" id="post-<?php the_ID(); ?>" >
		          <img class="card-img-top" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>" alt="<?php echo $alt; ?>">
		          <div class="card-header">
		            <h3 class="card-title"><?php the_title(); ?></h3>
		          </div>
		          <div class="card-body">
		            <p class="card-text"><?php the_excerpt(); ?></p>
		          </div>
							<?php uds_wp_entry_footer(); ?>
		          <div class="card-button">
		            <a href="<?php the_permalink(); ?>" class="btn btn-maroon">Read more</a>
		          </div>

		        </div> <!-- .card -->

		      </div>
