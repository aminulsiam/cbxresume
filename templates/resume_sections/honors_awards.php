<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://codeboxr.com
 * @since      1.0.7
 *
 * @package    cbxresume
 * @subpackage cbxresume/templates/resume_sections
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<?php do_action( 'cbxresume_details_honor_award_before', $resume_data ); ?>
	<div class="cbxresume_details_honor_award">
		<?php do_action( 'cbxresume_details_honor_award_start', $resume_data ); ?>

		<h3><?php echo esc_html__( 'Honors & Awards', 'cbxresume' ); ?></h3>
		<ul>
			<?php
			$resume_honors = isset( $resume['honor_award'] ) ? $resume['honor_award'] : array();

			foreach ( $resume_honors as $honor ) {
				?>
				<li><?php esc_html_e( $honor['title'] ) ?></li>
				<li><?php esc_html_e( $honor['associated_with'] ) ?></li>
				<li><?php esc_html_e( $honor['issuer'] ) ?></li>
				<li><?php esc_html_e( $honor['month'] ) ?></li>
				<li><?php esc_html_e( $honor['year'] ) ?></li>
				<li><?php esc_html_e( $honor['description'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_honor_award_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_honor_award_after', $resume_data ); ?>