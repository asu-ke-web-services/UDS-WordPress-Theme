<?php
/**
 * ASU Web Standards 2020 Theme functions and definitions
 *
 * @package asu-web-standards-2020
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$asu_wp2020_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/asu-favicons.php',                    // Enable ASU Favicons.
	'/wpautop.php',                         // Disable wpautop.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/wp-custom-fields.php',                // Disable WP Core custom fields metaboxes.
	'/advanced-custom-fields.php',          // Load integrated ACF plugin.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/blur-images-missing-alt-tag.php',     // Load A11y Image Blur css in editor (blur images missing alt tags).
	'/deprecated.php',                      // Load deprecated functions.
);

foreach ( $asu_wp2020_includes as $file ) {
	require_once get_template_directory() . '/inc' . $file;
}
