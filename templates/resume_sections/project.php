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
<?php do_action( 'cbxresume_details_project_before', $resume_data ); ?>
	<div class="cbxresume_details_project">
		<?php do_action( 'cbxresume_details_project_start', $resume_data ); ?>

		<h3><?php echo esc_html__( 'Project', 'cbxresume' ); ?></h3>
		<ul>
			<?php
			$resume_project = isset( $resume['project'] ) ? $resume['project'] : array();

			foreach ( $resume_project as $project ) {
				?>
				<li><?php esc_html_e( $project['project_name'] ) ?></li>
				<li><?php esc_html_e( $project['month'] ) ?></li>
				<li><?php esc_html_e( $project['year'] ) ?></li>
				<li><?php esc_html_e( $project['writter'] ) ?></li>
				<li><?php esc_html_e( $project['project_url'] ) ?></li>
				<li><?php esc_html_e( $project['associated_with'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_project_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_project_after', $resume_data ); ?>