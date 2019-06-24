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
<?php do_action( 'cbxresume_details_course_before', $resume_data ); ?>
	<div class="cbxresume_details_course">
		<?php

		$resume_course = isset( $resume['course'] ) ? $resume['course'] : array();

		if(empty($resume_course)){
		    return false;
        }

        do_action( 'cbxresume_details_course_start', $resume_data );

        ?>

		<h3><?php echo esc_html__( 'Course', 'cbxresume' ); ?></h3>
		<ul>
			<?php
			foreach ( $resume_course as $course ) {
				?>
				<li><?php esc_html_e( $course['name'] ) ?></li>
				<li><?php esc_html_e( $course['number'] ) ?></li>
				<li><?php esc_html_e( $course['associated_with'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_course_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_course_after', $resume_data ); ?>