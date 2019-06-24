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
<?php do_action( 'cbxresume_details_license_before', $resume_data ); ?>
	<div class="cbxresume_details_license">
		<?php
		$resume_license = isset( $resume['license'] ) ? $resume['license'] : array();

		if(empty($resume_license)){
		    return false;
        }

        do_action( 'cbxresume_details_license_start', $resume_data );
        ?>

		<h3><?php echo esc_html__( 'License', 'cbxresume' ); ?></h3>
		<ul>
			<?php
			foreach ( $resume_license as $license ) {
				?>
				<li><?php esc_html_e( $license['name'] ) ?></li>
				<li><?php esc_html_e( $license['issuing_organization'] ) ?></li>
				<li><?php esc_html_e( $license['issue_date'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_license_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_license_after', $resume_data ); ?>