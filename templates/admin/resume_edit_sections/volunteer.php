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

$resume_volunteer = isset( $resumes['volunteer'] ) ?
	$resumes['volunteer'] : array();

if ( ! is_array( $resume_volunteer ) ) {
	$resume_volunteer = array();
}
?>

<h2><?php echo esc_html__( 'Volunteer', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_volunteer">

    <div class="cbxresume_volunteers">
		<?php
		if ( sizeof( $resume_volunteer ) > 0 ) {
			foreach ( $resume_volunteer as $key => $volunteer ) {
				?>
                <div class="cbxresume_volunteer">
                    <input type="text"
                           name="cbxresume[volunteer][<?php echo
					       esc_attr( $key ); ?>][organization]"
                           value="<?php echo esc_attr__(
						       $volunteer['organization'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[volunteer][<?php echo
					       esc_attr( $key ); ?>][role]"
                           value="<?php echo esc_attr__(
						       $volunteer['role'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[volunteer][<?php echo
					       esc_attr( $key ); ?>][cause]"
                           value="<?php echo esc_attr__(
						       $volunteer['cause'] ); ?>"/>


                    <select name="cbxresume[volunteer][<?php echo
					esc_attr( $key ); ?>][from]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $volunteer['from'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>

                    <select name="cbxresume[volunteer][<?php echo
					esc_attr( $key ); ?>][to]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $volunteer['to'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>

                    <input type="text"
                           name="cbxresume[volunteer][<?php echo
					       esc_attr( $key ); ?>][description]"
                           value="<?php echo esc_attr__(
						       $volunteer['description'] ); ?>"/>


                    <a href="#" class="button cbxresume_volunteer_remove">
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
        <a data-busy="0" href="#" class="button cbxresume_volunteer_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Volunteer', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get license last count from db
	$volunteer_last_count = isset( $resumes['volunteer_last_count'] ) ?
		intval( $resumes['volunteer_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[volunteer_last_count]"
           class="cbxresume_volunteer_last_count"
           value="<?php echo esc_attr( $volunteer_last_count ); ?>"/>

</div> <!--- end volunteer section section --->