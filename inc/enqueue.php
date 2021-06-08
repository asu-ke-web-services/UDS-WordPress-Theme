<?php
/**
 * UDS WordPress Theme enqueue scripts
 *
 * @package uds-wordpress-theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'uds_wp_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function uds_wp_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/theme.min.css' );
		wp_enqueue_style( 'uds-wordpress-styles', get_template_directory_uri() . '/css/theme.min.css', array(), $css_version );

		wp_enqueue_script( 'jquery' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/theme.min.js' );
		wp_enqueue_script( 'uds-wordpress-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $js_version, true );


		$fa_js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/fontawesome/all.min.js' );
		wp_enqueue_script( 'uds-wordpress-fa-scripts', get_template_directory_uri() . '/js/fontawesome/all.min.js', array(), $fa_js_version, true );

		$js_hero_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/hero_video.js' );
		wp_enqueue_script( 'uds-wordpress-hero-video-scripts', get_template_directory_uri() . '/js/hero_video.js', array(), $js_hero_version, true );

		$js_back_to_top_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/back_to_top.js' );
		wp_enqueue_script( 'uds-wordpress-back-to-top-scripts', get_template_directory_uri() . '/js/back_to_top.js', array(), $js_back_to_top_version, true );

		$js_overlay_card_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/overlay-card.js' );
		wp_enqueue_script( 'uds-wordpress-overlay-card-scripts', get_template_directory_uri() . '/js/overlay-card.js', array(), $js_overlay_card_version, true );

		$js_play_button_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/play-button.js' );
		wp_enqueue_script( 'uds-wordpress-play-button-scripts', get_template_directory_uri() . '/js/play-button.js', array(), $js_play_button_version, true );

		$js_play_button_version2 = $theme_version . '.' . filemtime( get_template_directory() . '/js/tabs.js' );
		wp_enqueue_script( 'uds-wordpress-play-button-scripts2', get_template_directory_uri() . '/js/tabs.js', array(), $js_play_button_version2, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // End of if function_exists( 'uds_wp_scripts' ).
add_action( 'wp_enqueue_scripts', 'uds_wp_scripts' );



if ( ! function_exists( 'uds_wp_admin_scripts' ) ) {
	/**
	 * Load admin JavaScript and CSS sources.
	 */
	function uds_wp_admin_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/admin.css' );
		wp_enqueue_style( 'uds-wordpress-admin-styles', get_template_directory_uri() . '/css/admin.css', array(), $css_version );

		$fa_js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/fontawesome/all.min.js' );
		wp_enqueue_script( 'uds-wordpress-fa-scripts', get_template_directory_uri() . '/js/fontawesome/all.min.js', array(), $fa_js_version, true );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/core-list-block.js' );
		wp_enqueue_script( 'uds-wordpress-admin-scripts', get_template_directory_uri() . '/js/core-list-block.js', array(), $js_version );

		$js_divider_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/core-divider.js' );
		wp_enqueue_script( 'uds-wordpress-admin-divider-script', get_template_directory_uri() . '/js/core-divider.js', array(), $js_version );
	}
} // End of if function_exists( 'uds_wp_scripts' ).
add_action( 'admin_enqueue_scripts', 'uds_wp_admin_scripts' );


if ( ! function_exists( 'uds_wp_gutenberg_css' ) ) {
	/**
	 * Load CSS styles in editor area.
	 */
	function uds_wp_gutenberg_css() {
		add_theme_support( 'editor-styles' );
		add_editor_style( 'css/theme.min.css' );
	}
}// End of if function_exists( 'uds_wp_gutenberg_css' ).
add_action( 'after_setup_theme', 'uds_wp_gutenberg_css' );




if ( ! function_exists( 'uds_wp_theme_support_block_editor_opt_in' ) ) {
	/**
	 * Opt in features for the theme and the block editor.
	 * From: https://developer.wordpress.org/block-editor/developers/themes/theme-support/
	 */
	function uds_wp_theme_support_block_editor_opt_in() {
		add_theme_support( 'disable-custom-font-sizes' );
		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'disable-custom-gradients' );
		add_theme_support( 'responsive-embeds' );

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name' => esc_attr__( 'ASU Gold', 'uds-wordpress-theme' ),
					'slug' => 'asu-gold',
					'color' => '#ffc627',
				),
				array(
					'name' => esc_attr__( 'ASU Maroon', 'uds-wordpress-theme' ),
					'slug' => 'asu-maroon',
					'color' => '#8c1d40',
				),
				array(
					'name' => esc_attr__( 'ASU Blue', 'uds-wordpress-theme' ),
					'slug' => 'asu-blue',
					'color' => '#00A3E0',
				),
				array(
					'name' => esc_attr__( 'ASU Green', 'uds-wordpress-theme' ),
					'slug' => 'asu-green',
					'color' => '#78BE20',
				),
				array(
					'name' => esc_attr__( 'ASU Orange', 'uds-wordpress-theme' ),
					'slug' => 'asu-orange',
					'color' => '#ff7f32',
				),
				array(
					'name' => esc_attr__( 'ASU Gray 1', 'uds-wordpress-theme' ),
					'slug' => 'asu-gray-1',
					'color' => '#fafafa',
				),
				array(
					'name' => esc_attr__( 'ASU Gray 2', 'uds-wordpress-theme' ),
					'slug' => 'asu-gray-2',
					'color' => '#e8e8e8',
				),
				array(
					'name' => esc_attr__( 'ASU Gray 3', 'uds-wordpress-theme' ),
					'slug' => 'asu-gray-3',
					'color' => '#d0d0d0',
				),
				array(
					'name' => esc_attr__( 'ASU Gray 4', 'uds-wordpress-theme' ),
					'slug' => 'asu-gray-4',
					'color' => '#bfbfbf',
				),
				array(
					'name' => esc_attr__( 'ASU Gray 5', 'uds-wordpress-theme' ),
					'slug' => 'asu-gray-5',
					'color' => '#747474',
				),
				array(
					'name' => esc_attr__( 'ASU Gray 6', 'uds-wordpress-theme' ),
					'slug' => 'asu-gray-6',
					'color' => '#484848',
				),
				array(
					'name' => esc_attr__( 'ASU Gray 7', 'uds-wordpress-theme' ),
					'slug' => 'asu-gray-7',
					'color' => '#191919',
				),
				array(
					'name' => esc_attr__( 'ASU White', 'uds-wordpress-theme' ),
					'slug' => 'asu-white',
					'color' => '#ffffff',
				),
			)
		);
	}
}// End of if function_exists( 'uds_wp_theme_support_block_editor_opt_in' ).
add_action( 'after_setup_theme', 'uds_wp_theme_support_block_editor_opt_in' );
