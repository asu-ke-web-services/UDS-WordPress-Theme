<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package uds-wordpress-theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'uds_wp_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function uds_wp_posted_on() {
		$time_string = '<span class="fas fa-calendar-day"></span><time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( is_user_logged_in() ) {
			// Modify the time stamp to include both sets of dates if there is a user logged in.
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<span class="fas fa-calendar-day"></span><time class="entry-date published" datetime="%1$s">%2$s</time>  <time class="updated text-gray-4 pl-1" datetime="%3$s"> (Last updated: %4$s) </time>';
			}
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on   = apply_filters(
			'uds_wp_posted_on',
			sprintf(
				'<span class="posted-on">%1$s</span>',
				apply_filters( 'uds_wp_posted_on_time', $time_string )
			)
		);
		echo $posted_on; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'uds_wp_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function uds_wp_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			 // Translators: used between list items, there is a space after the comma.
			$categories_list = preg_replace( '/<a /', '<a class="btn btn-tag btn-tag-alt-white"', get_the_category_list( ' ' ) );

			if ( $categories_list && uds_wp_categorized_blog() ) {
				if ( ! is_single() ) {
					printf( '<div class="card-tags">%s</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					printf( '<div class="category-tags">%s</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'uds-wordpress-theme' ) );
			if ( $tags_list ) {
				/* translators: %s: Tags of current post */
				printf( '<div class="tags-links"><span class="fas fa-tags" title="Tags"></span>%s</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'uds-wordpress-theme' ), esc_html__( '1 Comment', 'uds-wordpress-theme' ), esc_html__( '% Comments', 'uds-wordpress-theme' ) );
			echo '</span>';
		}
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'uds-wordpress-theme' ),
				the_title( '<span class="sr-only">"', '"</span>', false )
			),
			'<div class="edit-link my-1">',
			'</div>'
		);
	}
}

if ( ! function_exists( 'uds_wp_categorized_blog' ) ) {
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	function uds_wp_categorized_blog() {
		$all_the_cool_cats = get_transient( 'uds_wp_categories' );
		if ( false === $all_the_cool_cats ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);
			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );
			set_transient( 'uds_wp_categories', $all_the_cool_cats );
		}
		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so uds_wp_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so uds_wp_categorized_blog should return false.
			return false;
		}
	}
}

add_action( 'edit_category', 'uds_wp_category_transient_flusher' );
add_action( 'save_post', 'uds_wp_category_transient_flusher' );

if ( ! function_exists( 'uds_wp_category_transient_flusher' ) ) {
	/**
	 * Flush out the transients used in uds_wp_categorized_blog.
	 */
	function uds_wp_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'uds_wp_categories' );
	}
}

if ( ! function_exists( 'uds_wp_body_attributes' ) ) {
	/**
	 * Displays the attributes for the body element.
	 */
	function uds_wp_body_attributes() {
		/**
		 * Filters the body attributes.
		 *
		 * @param array $atts An associative array of attributes.
		 */
		$atts = array_unique( apply_filters( 'uds_wp_body_attributes', $atts = array() ) );
		if ( ! is_array( $atts ) || empty( $atts ) ) {
			return;
		}
		$attributes = '';
		foreach ( $atts as $name => $value ) {
			if ( $value ) {
				$attributes .= sanitize_key( $name ) . '="' . esc_attr( $value ) . '" ';
			} else {
				$attributes .= sanitize_key( $name ) . ' ';
			}
		}
		echo trim( $attributes ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

if ( ! function_exists( 'uds_assign_featured_image' ) ) {
	/**
	 * Assign default featured image to each post.
	 *
	 * We are looking for suitable images in the following locations in this specific order.
	 *  1. A hero image from the post.
	 *  2. The first example of a core/image block in the post.
	 *  3. A hero image assigned to the primary category if Yoast is present.
	 *  4. A hero image from the first category from get_the_categories.
	 *
	 * Note: There is always a category assigned to each post, so by assigning one hero image
	 * to the default category for your WP install, you can ensure that all posts have featured images.
	 * The "default" category setting can be found in Settings-->Writing
	 *
	 * TODO: Check the post for an image assigned to a non-image block like a card, the content-overlap block, etc.
	 */
	function uds_assign_featured_image() {

		global $post;
		$attached_image_id = '';

		// Check to see if the post object exists and if there is a featured image.
		// Post object won't exist at all until the first save.
		if ( ( is_object( $post ) ) && ( ! has_post_thumbnail( $post->ID ) ) ) {

			// Step 1. Look at the ACF hero to see if there's a hero image.
			$hero_asset_data = '';
			$hero_asset_data = get_field( 'uds_story_hero_background_image', $post->ID );

			// If we found a suitable image assign it as the featured image.
			// Then bail early.
			if ( ! empty( $hero_asset_data ) ) {
				set_post_thumbnail( $post->ID, $hero_asset_data['ID'] );
				return;
			}

			// Step 2. Scan the post content, identify the first core/image block found and assign to featured image.
			if ( has_blocks( $post->post_content ) ) {

				$blocks = parse_blocks( $post->post_content );
				foreach ( $blocks as $value ) {
					if ( 'core/image' == $value['blockName'] ) {
						$attached_image_id = $value['attrs']['id'];
						break;
					}
				}
			}

			// If we found a suitable image assign it as the featured image.
			// Then bail early.
			if ( ! empty( $attached_image_id ) ) {
				set_post_thumbnail( $post->ID, $attached_image_id );
				return;
			}

			// Step 3 and 4: Let's look in the assigned categories for a suitable image.
			$primary_category_id = '';

			// Step 3: Look for a "primary" category from Yoast SEO in case there is one selected.
			// If Yoast is active and there are multiple categories, there will always be one selected.
			if ( function_exists( 'yoast_get_primary_term_id' ) ) {

				// Returns false if the function is available, but there is only one category.
				$primary_category_id = yoast_get_primary_term_id( 'category', $post->ID );
			}

			// Step 4: No category determined as of yet. Find the first one in the returned WP_Term array.
			if ( empty( $primary_category_id ) ) {
				$all_categories = '';
				$all_categories = get_the_category( $post->ID );
				$primary_category_id = $all_categories[0]->term_id;
			}

			// Get the ACF image field assigned to the selected category and assign it to the post.
			if ( $primary_category_id ) {
				$primary_category_term = get_term( $primary_category_id );
				$hero_asset_data = get_field( 'hero_asset_file', $primary_category_term );
			}

			// Assign the hero image from the category page.
			if ( ! empty( $hero_asset_data ) ) {
				set_post_thumbnail( $post->ID, $hero_asset_data['ID'] );
			}

			// OK, fine... there's really no suitable image found here.

		}

	}
	add_action( 'save_post', 'uds_assign_featured_image' );
	add_action( 'draft_to_publish', 'uds_assign_featured_image' );
	add_action( 'new_to_publish', 'uds_assign_featured_image' );
	add_action( 'pending_to_publish', 'uds_assign_featured_image' );
	add_action( 'future_to_publish', 'uds_assign_featured_image' );
}
