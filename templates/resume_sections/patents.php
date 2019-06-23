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
<?php do_action( 'cbxresume_details_patents_before', $resume_data ); ?>
	<div class="cbxresume_details_patent">
		<?php do_action( 'cbxresume_details_patents_start', $resume_data ); ?>

		<h3><?php echo esc_html__( 'Patents', 'cbxresume' ); ?></h3>
		<ul>
			<?php
			$resume_patent = isset( $resume['patent'] ) ? $resume['patent'] : array();

			foreach ( $resume_patent as $patent ) {
				?>
				<li><?php esc_html_e( $patent['title'] ) ?></li>
				<li><?php esc_html_e( $patent['office'] ) ?></li>
				<li><?php esc_html_e( $patent['application_number'] ) ?></li>
				<li><?php esc_html_e( $patent['issue_month'] ) ?></li>
				<li><?php esc_html_e( $patent['issue_day'] ) ?></li>
				<li><?php esc_html_e( $patent['issue_year'] ) ?></li>
				<li><?php esc_html_e( $patent['patent_url'] ) ?></li>
				<li><?php esc_html_e( $patent['description'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_patents_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_patents_after', $resume_data ); ?>