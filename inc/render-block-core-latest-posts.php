<?php
/**
 * Render the native block "core/latest-posts"
 *
 * @package uds-wordpress-theme
 * @tags
* @phpcs:disable WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_type
 */

remove_action( 'init', 'register_block_core_latest_posts', 10 );


$block_core_latest_posts_excerpt_length = 0;

if ( ! function_exists( 'render_block_core_latest_posts1' ) ) {
	/**
	 * Renders the `core/latest-posts` block on server.
	 *
	 * @param array $attributes The block attributes.
	 *
	 * @return string Returns the post content with latest posts added.
	 */
	function render_block_core_latest_posts1( $attributes ) {
		global $this_post, $block_core_latest_posts_excerpt_length;

		$args = array(
			'posts_per_page'   => $attributes['postsToShow'],
			'post_status'      => 'publish',
			'order'            => $attributes['order'],
			'orderby'          => $attributes['orderBy'],
			'suppress_filters' => false,
		);

		$block_core_latest_posts_excerpt_length = $attributes['excerptLength'];



		if ( isset( $attributes['categories'] ) ) {
			$args['category__in'] = array_column( $attributes['categories'], 'id' );
			$category_name = array_column( $attributes['categories'], 'name' );
		}
		if ( isset( $attributes['selectedAuthor'] ) ) {
			$args['author'] = $attributes['selectedAuthor'];
		}

		$recent_posts = get_posts( $args );

		$list_items_markup = '';

		foreach ( $recent_posts as $this_post ) {
			$post_link = esc_url( get_permalink( $this_post ) );
			if ( isset( $attributes['columns'] ) ) {
				if ( 2 == $attributes['columns'] ) {
					$attr_col = 6;
					$attr_col_md = 6;} elseif ( 3 == $attributes['columns'] ) {
					$attr_col = 4;
					$attr_col_md = 6;} elseif ( 4 == $attributes['columns'] ) {
						$attr_col = 3;
						$attr_col_md = 4;} elseif ( 5 == $attributes['columns'] ) {
						$attr_col = 2;
						$attr_col_md = 3;} elseif ( 6 == $attributes['columns'] ) {
							$attr_col = 1;
							$attr_col_md = 2;}
			}

			$card_class = 'card card-story';
			$image_classes = 'card-img-top';
			$header_class = 'card-header';
			$body_class = 'card-body';
			$link_open_tag = '<a href="%1$s">';
			$link_close_tag = '</a>';
			$card_margin = 'mb-4';

			$list_items_markup .= '<div class="col col-12 col-md-' . $attr_col_md . ' col-lg-' . $attr_col . ' ' . $card_margin . '"><div class="' . $card_class . '">';

			if ( $attributes['displayFeaturedImage'] && has_post_thumbnail( $this_post ) ) {
				$image_style = '';
				if ( isset( $attributes['featuredImageSizeWidth'] ) ) {
					$image_style .= sprintf( 'max-width:%spx;', $attributes['featuredImageSizeWidth'] );
				}
				if ( isset( $attributes['featuredImageSizeHeight'] ) ) {
					$image_style .= sprintf( 'max-height:%spx;', $attributes['featuredImageSizeHeight'] );
				}


				if ( isset( $attributes['featuredImageAlign'] ) ) {
					$image_classes .= ' align' . $attributes['featuredImageAlign'];
				}

				$featured_image = get_the_post_thumbnail(
					$this_post,
					$attributes['featuredImageSizeSlug'],
					array(
						'style' => $image_style,
					)
				);
				if ( $attributes['addLinkToFeaturedImage'] ) {
					$featured_image = sprintf(
						'<a href="%1$s">%2$s</a>',
						$post_link,
						$featured_image
					);
				}
				$list_items_markup .= sprintf(
					'<div class="%1$s">%2$s</div>',
					$image_classes,
					$featured_image
				);
			}


			$title = get_the_title( $this_post );
			if ( ! $title ) {
				$title = '(no title)';
			}
			$list_items_markup .= sprintf(
				'<div class="' . $header_class . '"><h3 class="card-title">' . $link_open_tag . '%2$s' . $link_close_tag . '</h3></div>',
				$post_link,
				$title
			);


			$list_items_markup_meta_data = '';
			if ( isset( $attributes['displayAuthor'] ) && $attributes['displayAuthor'] ) {
				$author_display_name = get_the_author_meta( 'display_name', $this_post->post_author );


					$byline = sprintf( 'by %s', $author_display_name );

				if ( ! empty( $author_display_name ) ) {
					$list_items_markup_meta_data .= sprintf(
						'<div class="card-event-icons"><div><i class="fas fa-user"></i></div><div class="wp-block-latest-posts__post-author">%1$s</div></div>',
						esc_html( $byline )
					);
				}
			}

			if ( isset( $attributes['displayPostDate'] ) && $attributes['displayPostDate'] ) {
				$list_items_markup_meta_data .= sprintf(
					'<div class="card-event-icons"><div><i class="fas fa-calendar-day"></i></div><div datetime="%1$s" class="wp-block-latest-posts__post-date">%2$s</div></div>',
					esc_attr( get_the_date( 'c', $this_post ) ),
					esc_html( get_the_date( '', $this_post ) )
				);
			}
			if ( '' != $list_items_markup_meta_data ) {
				$list_items_markup .= '<div class="card-event-details">' . $list_items_markup_meta_data . '</div>';
			}



			if ( isset( $attributes['displayPostContent'] ) && $attributes['displayPostContent']
			&& isset( $attributes['displayPostContentRadio'] ) && 'excerpt' === $attributes['displayPostContentRadio'] ) {

				$trimmed_excerpt = get_the_excerpt( $this_post );
				$trimmed_excerpt = wp_trim_words( $trimmed_excerpt, $block_core_latest_posts_excerpt_length, '...' );

				$list_items_markup .= sprintf(
					'<div class="' . $body_class . '"><p class="card-text">%1$s</p></div>',
					$trimmed_excerpt
				);
			}

			if ( isset( $attributes['displayPostContent'] ) && $attributes['displayPostContent']
			&& isset( $attributes['displayPostContentRadio'] ) && 'full_post' === $attributes['displayPostContentRadio'] ) {
				$list_items_markup .= sprintf(
					'<div class="' . $body_class . '">%1$s</div>',
					wp_kses_post( html_entity_decode( $this_post->post_content, ENT_QUOTES, get_option( 'blog_charset' ) ) )
				);
			}

			$list_items_markup .= "</div></div>\n";
		}


		$class = 'wp-block-latest-posts__list';


		if ( isset( $attributes['columns'] ) && 'grid' === $attributes['postLayout'] ) {
			$class .= ' row';
		}


		$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $class ) );

		return sprintf(
			'<div %1$s>%2$s</div>',
			$wrapper_attributes,
			$list_items_markup
		);
	}
}

if ( ! function_exists( 'register_block_core_latest_posts1' ) ) {
	/**
	 * Register a new block type `core/latest-posts`.
	 */
	function register_block_core_latest_posts1() {
		register_block_type(
			'core/latest-posts',
			array(
				'category' => 'widgets',
				'attributes' => array(
					'categories' => array(
						'type' => 'array',
						'items' => array(
							'type' => 'object',
						),
					),
					'selectedAuthor' => array(
						'type' => 'number',
					),
					'postsToShow' => array(
						'type' => 'number',
						'default' => 5,
					),
					'displayPostContent' => array(
						'type' => 'boolean',
						'default' => false,
					),
					'displayPostContentRadio' => array(
						'type' => 'string',
						'default' => 'excerpt',
					),
					'excerptLength' => array(
						'type' => 'number',
						'default' => 55,
					),
					'displayAuthor' => array(
						'type' => 'boolean',
						'default' => false,
					),
					'displayPostDate' => array(
						'type' => 'boolean',
						'default' => false,
					),
					'postLayout' => array(
						'type' => 'string',
						'default' => 'list',
					),
					'columns' => array(
						'type' => 'number',
						'default' => 3,
					),
					'order' => array(
						'type' => 'string',
						'default' => 'desc',
					),
					'orderBy' => array(
						'type' => 'string',
						'default' => 'date',
					),
					'displayFeaturedImage' => array(
						'type' => 'boolean',
						'default' => false,
					),
					'featuredImageAlign' => array(
						'type' => 'string',
						'enum' => array( 'left', 'center', 'right' ),
					),
					'featuredImageSizeSlug' => array(
						'type' => 'string',
						'default' => 'thumbnail',
					),
					'featuredImageSizeWidth' => array(
						'type' => 'number',
						'default' => null,
					),
					'featuredImageSizeHeight' => array(
						'type' => 'number',
						'default' => null,
					),
					'addLinkToFeaturedImage' => array(
						'type' => 'boolean',
						'default' => false,
					),
				),
				'supports' => array(
					'align' => true,
					'html' => false,
				),
				'render_callback' => 'render_block_core_latest_posts1',
			)
		);
	}
}
add_action( 'init', 'register_block_core_latest_posts1' );
