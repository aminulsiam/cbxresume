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


$resume_experience = isset( $resumes['experience'] ) ?
	$resumes['experience'] : array();

if ( ! is_array( $resume_experience ) ) {
	$resume_experience = array();
}

?>

<h2><?php echo esc_html__( 'Experience', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_experience">

    <div class="cbxresume_experiences">
		<?php
		if ( sizeof( $resume_experience ) > 0 ) {
			foreach ( $resume_experience as $key => $experience ) {
				?>
                <div class="cbxresume_experience">
                    <input type="text"
                           name="cbxresume[experience][<?php echo
					       esc_attr( $key ); ?>][title]"
                           value="<?php echo esc_attr__(
						       $experience['title'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[experience][<?php echo
					       esc_attr( $key ); ?>][company]"
                           value="<?php echo esc_attr__(
						       $experience['company'] ); ?>"/>

                    <select name="cbxresume[experience][<?php echo
					esc_attr( $key ); ?>][start_date]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $experience['start_date'], $i );
								?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>


                    <input type="text"
                           name="cbxresume[experience][<?php echo
					       esc_attr( $key ); ?>][description]"
                           value="<?php echo esc_attr__(
						       $experience['description'] ); ?>"/>

                    <a href="#" class="button cbxresume_experience_remove"><span class="dashicons dashicons-trash"
                                                                                 style="margin-top: 3px;margin-bottom :10px;color: red;"></span><?php echo esc_html__( 'Remove',
							'cbxresume' );
						?></a>

                </div>
				<?php
			}
		}
		?>
    </div>

    <!-- Add new experience button -->
    <p>
        <a data-busy="0" href="#" class="button cbxresume_experience_add"><span class="dashicons dashicons-plus-alt"
                                                                                style="margin-top:3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Experience', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get experience last count from db
	$experience_last_count = isset( $resumes['experience_last_count'] ) ?
		intval( $resumes['experience_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[experience_last_count]"
           class="cbxresume_experience_last_count"
           value="<?php echo esc_attr( $experience_last_count ); ?>"/>

</div> <!-- end cbxresume experience section -->

