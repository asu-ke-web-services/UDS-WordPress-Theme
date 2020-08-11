<?php

/*
Plugin Name: Blur No-Alt
Plugin URI: http://kerri.is/
Description: Blur images in the WP editor interface if they don't have alt text
Author: Kerri Hicks
*/

function asu_wp2020_blur_admin_theme_style()
{
	wp_enqueue_style('blur-admin-theme', '/css/blur-no-alt.css');
}
add_action('admin_enqueue_scripts', 'asu_wp2020_blur_admin_theme_style');
