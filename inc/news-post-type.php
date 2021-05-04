<?php
/**
 * Create a news post type
 *
 * @package uds-wordpress-theme
 */

// phpcs:disable WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_register_post_type, WPThemeReview.PluginTerritory.ForbiddenFunctions.plugin_territory_flush_rewrite_rules

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'create_news_post_type' ) ) {

	/**
	 * A function to create a news post type
	 */
	function create_news_post_type() {

		register_post_type(
			'news_post',
			array(
				'labels'      => array(
					'name'          => __( 'News', 'uds-wordpress-theme' ),
				),
				'public'                => true,
				'has_archive' => true,
				'capability_type'       => 'post',
				'map_meta_cap'          => true,
				'menu_position'         => 6,
				'menu_icon'             => 'dashicons-welcome-widgets-menus',
				'hierarchical'          => false,
				'rewrite' => true,
				'query_var'             => false,
				'delete_with_user'      => true,
				'show_in_rest'          => true,
				'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'post-formats' ),
			)
		);
		flush_rewrite_rules();

	}
	add_action( 'init', 'create_news_post_type' );
}

if ( ! function_exists( 'news_post_type_thumbnail' ) ) {
	/**
	 * This function is to load the featured image feild after setup the theme
	 * so that we can get this field loaded on the new created custom post type (News)
	 */
	function news_post_type_thumbnail() {
		add_theme_support( 'post-thumbnails' );
	}
	add_action( 'after_setup_theme', 'news_post_type_thumbnail' );

}

if ( ! function_exists( 'wpseo_remove_breadcrumb_link' ) ) {

	/**
	 * A function to update the breadcrumb single link wrapper
	 *
	 * @param link_output $link_output displays the individual breadcrumb item.
	 */
	function wpseo_remove_breadcrumb_link( $link_output ) {
		// $link_output=preg_replace('#</?span[^>]*>#is', '', $link_output);
		return '<li class="breadcrumb-item">' . $link_output . '</li>';
	}

	add_filter( 'wpseo_breadcrumb_single_link', 'wpseo_remove_breadcrumb_link', 10, 2 );
}
