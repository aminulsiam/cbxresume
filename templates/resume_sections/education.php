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
<?php do_action( 'cbxresume_details_education_before', $resume_data ); ?>
    <div class="cbxresume_details_education">
		<?php do_action( 'cbxresume_details_education_start', $resume_data ); ?>
        <h3><?php echo esc_html__( 'Education', 'cbxresume' ); ?></h3>

		<?php
		$resume_education = isset( $resume['education'] ) ? $resume['education'] : array();

		foreach ( $resume_education as $education ) {
			?>
            <ul>
                <li><?php esc_html_e( $education['institute'] ) ?></li>
                <li><?php esc_html_e( $education['degree'] ) ?></li>
                <li><?php esc_html_e( $education['field'] ) ?></li>
                <li><?php esc_html_e( $education['from'] ) ?></li>
                <li><?php esc_html_e( $education['to'] ) ?></li>
                <li><?php esc_html_e( $education['grade'] ) ?></li>
                <li><?php esc_html_e( $education['activity'] ) ?></li>
                <li><?php esc_html_e( $education['description'] ) ?></li>
            </ul>
		<?php } ?>
		<?php do_action( 'cbxresume_details_education_end', $resume_data ); ?>
    </div>
<?php do_action( 'cbxresume_details_education_after', $resume_data ); ?>