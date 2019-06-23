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
<?php do_action( 'cbxresume_details_test_score_before', $resume_data ); ?>
	<div class="cbxresume_details_test_score">
		<?php do_action( 'cbxresume_details_test_score_start', $resume_data ); ?>

		<h3><?php echo esc_html__( 'Test score', 'cbxresume' ); ?></h3>
		<ul>
			<?php
			$resume_test_score = isset( $resume['test_score'] ) ? $resume['test_score'] : array();

			foreach ( $resume_test_score as $test_score ) {
				?>
				<li><?php esc_html_e( $test_score['test_name'] ) ?></li>
				<li><?php esc_html_e( $test_score['associated_with'] ) ?></li>
				<li><?php esc_html_e( $test_score['score'] ) ?></li>
				<li><?php esc_html_e( $test_score['month'] ) ?></li>
				<li><?php esc_html_e( $test_score['year'] ) ?></li>
				<li><?php esc_html_e( $test_score['description'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_test_score_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_test_score_after', $resume_data ); ?>