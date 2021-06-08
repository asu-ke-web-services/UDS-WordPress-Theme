<?php
/**
 * Block Registration
 *
 * Block name: Tabs and Accodion block
 * Author: Zainab
 * Version: 1.0
 *
 * @package UDS WordPress Theme
 *
 * Notes: UDS Tabs and Accodion block
 *
 * Note: for the icon, you can use any Dashicon:
 * https://developer.wordpress.org/resource/dashicons, OR an actual <SVG></SVG> tag
 * with all the required content. In this example, I'm using a dashicon.
 */

acf_register_block_type(
	array(
		'name'              => 'uds-tabs', // internal name, like a slug.
		'title'             => __( 'UDS Tabs and Accordions', 'uds-wordpress-theme' ), // name the user will see.
		'description'       => __( 'A block for tabs and accordions', 'uds-wordpress-theme' ), // description the user will see.
		'icon'              => 'table-row-after', // Dashicon, or custom SVG code, for the icon.
		'render_template'   => 'templates-blocks/tabs/tabs.php', // location of the block's template.
		'category'          => 'uds', // category this block appears in.
		'keywords'          => array( 'tab', 'tabs', 'content', 'accordion', 'accordions', 'video', 'videos' ),
		'supports'          => array(
			'align' => false, // Remove the align button in the editor toolbar.
		),
		'mode'              => 'edit', // make this block default to preview mode when added to the page.
		'example'           => array(
			'attributes' => array(
				'mode' => 'preview', // show the actual tabs view for the preview when adding this block.
				'data' => array(
					'tabs_style'        => 'regular_horizonal',
					'tabs'        => array(
						'tab_title'        => 'This is the tab title',
						'tab_content'        => 'text_content',
						'text_content' => 'This is the tab content',

					),

				),
			),
		),
	)
);
