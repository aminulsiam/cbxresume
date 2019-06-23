<?php
/**
 * Provide a admin resume edit view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://codeboxr.com
 * @since      1.0.7
 *
 * @package    cbxresume
 * @subpackage cbxresume/templates/admin/resume_edit_sections
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$resume_course = isset( $resumes['course'] ) ?
	$resumes['course'] : array();

if ( ! is_array( $resume_course ) ) {
	$resume_course = array();
}
?>

<h2><?php echo esc_html__( 'Course', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_course">

    <div class="cbxresume_courses">
		<?php
		if ( sizeof( $resume_course ) > 0 ) {
			foreach ( $resume_course as $key => $course ) {
				?>
                <div class="cbxresume_course">
                    <input type="text"
                           name="cbxresume[course][<?php echo
					       esc_attr( $key ); ?>][name]"
                           value="<?php echo esc_attr__(
						       $course['name'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[course][<?php echo
					       esc_attr( $key ); ?>][number]"
                           value="<?php echo esc_attr__(
						       $course['number'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[course][<?php echo
					       esc_attr( $key ); ?>][associated_with]"
                           value="<?php echo esc_attr__(
						       $course['associated_with'] ); ?>"/>

                    <a href="#" class="button cbxresume_course_remove">
                                                                    <span class="dashicons dashicons-trash"
                                                                          style="margin-top: 3px;margin-bottom :10px;
                                                                            color: red;"></span><?php echo esc_html__(
							'Remove', 'cbxresume' ); ?></a>
                </div>
				<?php
			}
		}
		?>
    </div>

    <!-- Add new license button -->
    <p>
        <a data-busy="0" href="#" class="button cbxresume_course_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Course', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get license last count from db
	$course_last_count = isset( $resumes['course_last_count'] ) ?
		intval( $resumes['course_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[course_last_count]"
           class="cbxresume_course_last_count"
           value="<?php echo esc_attr( $course_last_count ); ?>"/>

</div> <!--- end course section --->
