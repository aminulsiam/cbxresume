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

$resume_education = isset( $resumes['education'] ) ? $resumes['education'] : array();

if ( ! is_array( $resume_education ) ) {
	$resume_education = array();
}

?>

<div class="cbxresume_section cbxresume_section_education">
    <h2><?php echo esc_html__( 'Education ', 'cbxresume' ); ?></h2>
    <div class="cbxresume_educations">
		<?php
		if ( sizeof( $resume_education ) > 0 ) {
			foreach ( $resume_education as $key => $education ) {
				?>
                <div class="cbxresume_education">
                    <input type="text"
                           name="cbxresume[education][<?php echo
					       esc_attr( $key ); ?>][institute]"
                           value="<?php echo esc_attr__(
						       $education['institute'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[education][<?php echo
					       esc_attr( $key ); ?>][degree]"
                           value="<?php echo esc_attr__(
						       $education['degree'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[education][<?php echo
					       esc_attr( $key ); ?>][field]"
                           value="<?php echo esc_attr__(
						       $education['field'] ); ?>"/>

                    <select name="cbxresume[education][<?php echo
					esc_attr( $key ); ?>][from]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $education['from'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>

                    <select name="cbxresume[education][<?php echo
					esc_attr( $key ); ?>][to]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $education['to'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>

                    <input type="text" name="cbxresume[education][<?php echo
					esc_attr( $key ); ?>][grade]"
                           value="<?php echo esc_attr__(
						       $education['grade'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[education][<?php echo
					       esc_attr( $key ); ?>][activity]"
                           value="<?php echo esc_attr__(
						       $education['activity'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[education][<?php echo
					       esc_attr( $key ); ?>][description]"
                           value="<?php echo esc_attr__(
						       $education['description'] ); ?>"/>

                    <a href="#" class="button cbxresume_education_remove">
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

    <!-- Add new education button -->
    <p>
        <a data-busy="0" href="#" class="button cbxresume_education_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add New Education', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get education last count from db
	$education_last_count = isset( $resumes['education_last_count'] ) ?
		intval( $resumes['education_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[education_last_count]"
           class="cbxresume_education_last_count"
           value="<?php echo esc_attr( $education_last_count ); ?>"/>

</div> <!-- end cbxresume education section -->