<?php
/**
 * UDS Card Block
 *
 * @package UDS WordPress Theme
 * @author Walter McConnell
 *
 * A block for creating static versions of a UDS card. Supports the following features:
 *
 * - basic, story, and event card formats with
 * - vertical or horizontal cards
 * - blank, image, or icon header styles
 * - ability to add multiple buttons, links, or tags (or all three!)
 * - simple date and time values for event cards
 *
 * Note: horizontal cards have a different structure, so when horizontal is
 * chosen, a new <div> with the class 'card-content-wrapper' is added to
 * via two conditional statements.
 */

/** Determine card style classes to use. Rather than use actual class names in
 * in the ACF field group, we have it give us basic values and determine the
 * class names here
 */
$style = get_field( 'card_style' );
switch ( $style ) {
	case 'degree':
		$style_class = 'card-degree';
		break;

	case 'event':
		$style_class = 'card-event';
		break;

	case 'story':
		$style_class = 'card-story';
		break;

	default:
		$style_class = '';
		break;
}

// Get the header style: none, image, or icon.
$header_style = get_field( 'header_style' );

// Get the orientation value and set a class if horizontal.
if ( 'horizontal' == get_field( 'card_orientation' ) ) {
	$orientation_class = 'card-horizontal';
} else {
	$orientation_class = '';
}

// If there's an icon, clean it up for use.
$icon_name = get_field( 'header_icon' );
if ( 'icon' == $header_style && '' != $icon_name ) {
	$icon_name = sanitize_text_field( $icon_name );
}

// Retrieve additional classes from the 'advanced' field in the editor.
if ( ! empty( $block['className'] ) ) {
	$additional_classes = sanitize_text_field( $block['className'] );
}

// Check for the 'hover' variant, and set up some hover-specific variables.
$hover_class = '';
$hover_target_text = '';

if ( true === get_field( 'hover' ) ) {
	$is_hover_card = true;

	$hover_link_data = get_field( 'card_hover_link' );
	$hover_url = $hover_link_data['url'];
	$hover_target = $hover_link_data['target'];

	if ( ! empty( $hover_target ) ) {
		$hover_target_text = 'target="' . $hover_target . '"';
	}

	$hover_class = 'card-hover';
}

// Get our image data from the array provided by ACF.
$image_url = '';
$image_alt = '';

$image_data = get_field( 'image' );

if ( ! empty( $image_data ) ) {
	$image_url = $image_data['url'];
	$image_alt = $image_data['alt'];
}
?>

<div class="card <?php echo $style_class; ?> <?php echo $orientation_class; ?> <?php echo $additional_classes; ?> <?php echo $hover_class; ?>">

	<?php if ( $is_hover_card ) : ?>
		<a href="<?php echo $hover_url; ?>" <?php echo $hover_target_text; ?>" class="hover-card-link">
	<?php endif; ?>

	<?php if ( 'image' == $header_style ) : ?>
		<img class="card-img-top" src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>">
	<?php endif; ?>
	<?php if ( 'icon' == $header_style ) : ?>
		<i class="fas fa-<?php echo $icon_name; ?> fa-2x card-icon-top"></i>
	<?php endif; ?>
		<?php if ( 'card-horizontal' == $orientation_class ) : ?>
			<div class="card-content-wrapper" />
		<?php endif; ?>
			<div class="card-header">
				<h3 class="card-title"><?php echo sanitize_text_field( get_field( 'title' ), '' ); ?></h3>
			</div>
		<?php if ( '' !== get_field( 'body_text' ) ) : ?>
			<div class="card-body">
				<p class="card-text"><?php echo wp_kses( get_field( 'body_text' ), '' ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( 'event' === get_field( 'card_style' ) ) : ?>
			<?php if ( get_field( 'start_date' ) || get_field( 'start_time' ) ) : ?>
				<div class="card-event-details">
					<div class="card-event-icons">
							<div><i class="fas fa-calendar"></i></div>
							<div>
								<?php the_field( 'start_date' ); ?><br>
								<?php the_field( 'start_time' ); ?>
								<?php if ( get_field( 'end_time' ) ) : ?>
									&nbsp;&ndash;&nbsp;<?php the_field( 'end_time' ); ?>
								<?php endif; ?>
							</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( get_field( 'location' ) ) : ?>
				<div class="card-event-details">
					<div class="card-event-icons">
						<div><i class="fas fa-map-marker-alt"></i></div>
						<div><?php echo sanitize_text_field( get_field( 'location' ) ); ?></div>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php
			// Show buttons, links and tags ONLY if 'hover' is false/no.
		if ( ! get_field( 'hover' ) ) :
			?>

			<?php if ( get_field( 'buttons' ) ) : ?>
				<?php if ( have_rows( 'buttons' ) ) : ?>
					<?php
					while ( have_rows( 'buttons' ) ) :
						the_row();
						?>
						<div class="card-button">
							<?php
								// Get our ACF Field values.
								$external_link = get_sub_field( 'card_buttons_external_link' );
								$button_color  = get_sub_field( 'card_buttons_button_color' );
								$button_size   = get_sub_field( 'card_buttons_button_size' );
								$button_icon   = get_sub_field( 'card_buttons_icon' );
								// These come in from the ACF cloned fields from the button group.
								$link_values   = get_sub_field( 'card_buttons_button_link' );
								$button_label  = sanitize_text_field( $link_values['title'] );
								$button_url    = esc_url( $link_values['url'] );
								$button_target = $link_values['target'];

							// Set "rel" text if requested.
							if ( $external_link ) {
								$rel = 'rel="noopener noreferrer"';
							} else {
								$rel = '';
							}

							// Set the text for the button size class.
							if ( 'default' !== $button_size ) {
								$button_size = 'btn-' . $button_size;
							} else {
								$button_size = '';
							}

							// Set the text for the icon, if requested.
							if ( $button_icon ) {
								$button_icon = sanitize_text_field( $button_icon );
								$icon_span = '<span class="fas fa-' . $button_icon . '"></span>&nbsp;&nbsp;';
							} else {
								$icon_span = '';
							}

							// Set the text for a target of "_blank" if opening in a new tab.
							if ( $button_target ) {
								$target_text = 'target="' . $button_target . '"';
							} else {
								$target_text = '';
							}
							?>
							<a href="<?php echo $button_url; ?>" class="btn <?php echo $button_size; ?> btn-<?php echo $button_color; ?>" <?php echo $rel; ?> <?php echo $target_text; ?>><?php echo $icon_span; ?><?php echo $button_label; ?></a>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( get_field( 'links' ) ) : ?>
				<?php if ( have_rows( 'links' ) ) : ?>
					<div class="card-link">
					<?php
					while ( have_rows( 'links' ) ) :
						the_row();
						?>
						<?php
							$link_label = sanitize_text_field( get_sub_field( 'link_text' ) );
							$link_url = esc_url( get_sub_field( 'link_url' ) );
							$external_link = get_sub_field( 'external_link' );

						if ( $external_link ) {
							$rel = 'rel="noopener noreferrer"';
						} else {
							$rel = '';
						}
						?>
						<a href="<?php echo $link_url; ?>" <?php echo $rel; ?>><?php echo $link_label; ?></a>
					<?php endwhile; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( get_field( 'tags' ) ) : ?>
				<?php if ( have_rows( 'tags' ) ) : ?>
					<div class="card-tags">
					<?php
					while ( have_rows( 'tags' ) ) :
						the_row();
						?>
						<?php
							$tag_label = sanitize_text_field( get_sub_field( 'tag_text' ) );
							$tag_url = esc_url( get_sub_field( 'tag_url' ) );
						?>
						<a class="btn btn-tag btn-tag-alt-white" href="<?php echo $tag_url; ?>" ><?php echo $tag_label; ?></a>
					<?php endwhile; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( 'card-horizontal' == $orientation_class ) : ?>
				</div> <!-- close horizontal content -->
			<?php endif; ?>

		<?php endif; // end if/then for hover. ?>

		<?php if ( $is_hover_card ) : ?>
			</a>
		<?php endif; ?>
</div>
