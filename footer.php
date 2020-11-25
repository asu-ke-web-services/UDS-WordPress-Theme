<?php
/**
 * The template for displaying the footer
 *
 * @package uds-wordpress-theme
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$c_options              = array();
$footer_row_branding   = 'enabled';
$footer_row_actions    = 'enabled';

if ( is_array( get_option( 'uds_wp_theme_options' ) ) ) {
	$c_options = get_option( 'uds_wp_theme_options' );
}

// Do we have an footer_row_branding setting?
if ( ! empty( $c_options['footer_row_branding'] ) ) {
	$footer_row_branding = $c_options['footer_row_branding'];
}
// Do we have an footer_row_actions setting?
if ( ! empty( $c_options['footer_row_actions'] ) ) {
	$footer_row_actions = $c_options['footer_row_actions'];
}
?>

<?php do_action( 'uds_wp_before_global_footer' ); ?>

<footer role="contentinfo">
	<?php
	if ( 'enabled' === $footer_row_branding ) :
		?>
	<div class="wrapper" id="wrapper-endorsed-footer">
		<div class="container" id="endorsed-footer">
			<div class="row">

				<div class="col-md" id="endorsed-logo">
					<?php
					// =============================
					// = Endorsed Logo             =
					// =============================
					// Do we have a Unit logo?
					$logo = '<img src="%1$s" alt="%2$s" />';

					// First, check for Preset Logo Selection.
					if ( isset( $c_options ) && array_key_exists( 'logo_select', $c_options ) && 'none' !== $c_options['logo_select'] ) {
						// load array of endorsed units.
						$endorsed_logos = uds_wp_theme_get_endorsed_unit_logos();

						// lookup logo filename.
						$filename = '';
						foreach ( $endorsed_logos as $unit ) {
							if ( $unit['slug'] === $c_options['logo_select'] ) {
								$filename = $unit['filename'];
								break;
							}
						}
						echo wp_kses( sprintf( $logo, get_template_directory_uri() . '/img/endorsed-logo/' . $filename, get_bloginfo( 'name' ) . ' Logo', home_url( '/' ) ), wp_kses_allowed_html( 'post' ) );

						// Else, check for Logo URL.
					} elseif ( isset( $c_options ) && array_key_exists( 'logo_url', $c_options ) && '' !== $c_options['logo_url'] ) {
						echo wp_kses( sprintf( $logo, $c_options['logo_url'], get_bloginfo( 'name' ) . ' Logo', home_url( '/' ) ), wp_kses_allowed_html( 'post' ) );
					}
					?>
				</div>

				<?php
				if ( has_nav_menu( 'social-media' ) ) {

					wp_nav_menu(
						array(
							'theme_location'  => 'social-media',
							'container' => 'div',
							'container_class' => 'col-md',
							'container_id' => 'social-media',
							'menu_class'  => '',
							'items_wrap' => '<nav aria-label="Social Media" class="nav">%3$s</nav>',
							'walker' => new WP_Social_Media_Walker(),
						)
					);
				}
				?>

			</div> <!-- row -->
		</div> <!-- endorsed-footer -->
	</div> <!-- wrapper-endorsed-footer -->
		<?php
	endif;

	do_action( 'uds_wp_before_global_footer_columns' );

	if ( 'enabled' === $footer_row_actions ) :
		?>
	<div class="wrapper" id="wrapper-footer-columns">
		<nav aria-label="Footer">
			<div class="container" id="footer-columns">
				<div class="row">

					<div class="col-xl-3" id="info-column">
						<?php
						// =============================
						// = Unit Name                 =
						// =============================
						$org_name = '<h5>%1$s</h5>';
						echo wp_kses( sprintf( $org_name, get_bloginfo( 'name' ) ), wp_kses_allowed_html( 'post' ) );

						// =============================
						// = Contact Us Email or URL   =
						// =============================
						$contact_url = '<p class="contact-link"><a href="%1$s%2$s%3$s">Contact Us</a></p>';

						// Do we have a contact?
						if (
							isset( $c_options ) &&
							array_key_exists( 'contact_email', $c_options ) &&
							'' !== $c_options['contact_email']
						) {
							$contact_type  = '';
							$contact_email = $c_options['contact_email'];
							$additional    = '';

							if ( filter_var( $contact_email, FILTER_VALIDATE_EMAIL ) ) {
								$contact_type = 'mailto:';

								// =============================
								// = Contact Us Email Subject  =
								// =============================

								// Do we have a subject line?
								if (
									array_key_exists( 'contact_subject', $c_options ) &&
									'' !== $c_options['contact_subject']
								) {
									$additional .= '&subject=' . rawurlencode( $c_options['contact_subject'] );
								}

								// =============================
								// = Contact Us Email Body     =
								// =============================

								// Do we have a body?
								if (
									array_key_exists( 'contact_body', $c_options ) &&
									'' !== $c_options['contact_body']
								) {
									$additional .= '&body=' . rawurlencode( $c_options['contact_body'] );
								}

								// Fix the additional part.
								if ( strlen( $additional ) > 0 ) {
									$additional = substr_replace( $additional, '?', 0, 1 );
								}
							}

							echo wp_kses( sprintf( $contact_url, $contact_type, $contact_email, $additional ), wp_kses_allowed_html( 'post' ) );
						}
						?>
						<?php
						// =============================
						// = Contribute Button         =
						// =============================
						$contribute_url = '<p class="contribute-button"><a href="%s" type="button" class="btn btn-gold">Contribute</a></p>';

						// Do we have a contribute?
						if (
							isset( $c_options ) &&
							array_key_exists( 'contribute_url', $c_options ) &&
							'' !== $c_options['contribute_url']
						) {
							echo wp_kses( sprintf( $contribute_url, $c_options['contribute_url'] ), wp_kses_allowed_html( 'post' ) );
						}
						?>
					</div>
					<?php
					include get_template_directory() . '/asu-footer-menu.php';
					?>
				</div> <!-- row -->
			</div> <!-- footer-columns -->
		</nav>
	</div> <!-- wrapper-footer-columns -->
		<?php
	endif;
	?>
	<div class="wrapper" id="wrapper-footer-innovation">
		<div class="container" id="footer-innovation">
			<div class="row">
				<div class="col">
					<div class="d-flex footer-innovation-links">
						<img src="<?php echo get_template_directory_uri(); ?>/img/innovation-lockup/on-gold/200420-GlobalFooter-No1InnovationLockup.png" alt="Number one in the U.S. for innovation. #1 ASU, #2 Stanford, #3 MIT. - U.S. News and World Report, 5 years, 2016-2020">
						<nav class="nav" aria-label="University Services">
							<a class="nav-link" href="https://asu.edu/map/">Maps and Locations</a>
							<a class="nav-link" href="https://asu.edu/asujobs">Jobs</a>
							<a class="nav-link" href="https://isearch.asu.edu/">Directory</a>
							<a class="nav-link" href="https://asu.edu/contactasu/">Contact ASU</a>
							<a class="nav-link" href="https://my.asu.edu/">My ASU</a>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- wrapper-footer-innovation -->

	<div class="wrapper" id="wrapper-footer-colophon">
		<div class="container" id="footer-colophon">
			<div class="row">
				<div class="col">
					<nav class="nav colophon" aria-label="University Legal and Compliance">
						<a class="nav-link" href="https://asu.edu/copyright/">Copyright and Trademark</a>
						<a class="nav-link" href="https://asu.edu/accessibility/">Accessibility</a>
						<a class="nav-link" href="https://asu.edu/privacy/">Privacy</a>
						<a class="nav-link" href="https://asu.edu/tou/">Terms of Use</a>
						<a class="nav-link" href="https://asu.edu/emergency/">Emergency</a>
					</nav>
				</div>
			</div>
		</div>
	</div> <!-- wrapper-footer-colophon -->
</footer>

<?php wp_footer(); ?>

</body>

</html>
