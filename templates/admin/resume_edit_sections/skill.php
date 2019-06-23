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

$resume_skill = isset( $resumes['skill'] ) ?
	$resumes['skill'] : array();

if ( ! is_array( $resume_skill ) ) {
	$resume_skill = array();
}
?>

<h2><?php echo esc_html__( 'Skill', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_skill">

	<div class="cbxresume_skills">
		<?php
		if ( sizeof( $resume_skill ) > 0 ) {
			foreach ( $resume_skill as $key => $skill ) {
				?>
				<div class="cbxresume_skill">
					<input type="text"
					       name="cbxresume[skill][<?php echo
					       esc_attr( $key ); ?>]"
					       value="<?php echo esc_attr__( $skill ); ?>"/>

					<a href="#" class="button cbxresume_skill_remove">
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

	<!-- Add new skill button -->
	<p>
		<a data-busy="0" href="#" class="button cbxresume_skill_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Skills', 'cbxresume' ); ?>
		</a>
	</p>

	<?php
	// Get language last count from db
	$skill_last_count = isset( $resumes['skill_last_count'] ) ?
		intval( $resumes['skill_last_count'] ) : 0;
	?>

	<!-- cbx resume last count field -->
	<input type="hidden" name="cbxresume[skill_last_count]"
	       class="cbxresume_skill_last_count"
	       value="<?php echo esc_attr( $skill_last_count ); ?>"/>

</div> <!-- end cbxresume skill section -->