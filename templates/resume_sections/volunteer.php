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
<?php do_action( 'cbxresume_details_volunteer_before', $resume_data ); ?>
	<div class="cbxresume_details_volunteer">
		<?php do_action( 'cbxresume_details_volunteer_start', $resume_data ); ?>

		<h3><?php echo esc_html__( 'Volunteer', 'cbxresume' ); ?></h3>
		<ul>
			<?php
			$resume_volunteer = isset( $resume['volunteer'] ) ? $resume['volunteer'] : array();

			foreach ( $resume_volunteer as $volunteer ) {
				?>
				<li><?php esc_html_e( $volunteer['organization'] ) ?></li>
				<li><?php esc_html_e( $volunteer['role'] ) ?></li>
				<li><?php esc_html_e( $volunteer['cause'] ) ?></li>
				<li><?php esc_html_e( $volunteer['from'] ) ?></li>
				<li><?php esc_html_e( $volunteer['to'] ) ?></li>
				<li><?php esc_html_e( $volunteer['description'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_volunteer_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_volunteer_after', $resume_data ); ?>