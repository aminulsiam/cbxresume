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

$resume_license = isset( $resumes['license'] ) ?
	$resumes['license'] : array();

if ( ! is_array( $resume_license ) ) {
	$resume_license = array();
}
?>

<h2><?php echo esc_html__( 'License', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_license">

    <div class="cbxresume_licenses">
		<?php
		if ( sizeof( $resume_license ) > 0 ) {
			foreach ( $resume_license as $key => $license ) {
				?>
                <div class="cbxresume_license">
                    <input type="text"
                           name="cbxresume[license][<?php echo
					       esc_attr( $key ); ?>][name]"
                           value="<?php echo esc_attr__(
						       $license['name'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[license][<?php echo
					       esc_attr( $key ); ?>][issuing_organization]"
                           value="<?php echo esc_attr__(
						       $license['issuing_organization'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[license][<?php echo
					       esc_attr( $key ); ?>][issue_date]"
                           value="<?php echo esc_attr__(
						       $license['issue_date'] ); ?>"/>

                    <a href="#" class="button cbxresume_license_remove">
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
        <a data-busy="0" href="#" class="button cbxresume_license_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add License', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get license last count from db
	$license_last_count = isset( $resumes['license_last_count'] ) ?
		intval( $resumes['license_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[license_last_count]"
           class="cbxresume_license_last_count"
           value="<?php echo esc_attr( $license_last_count ); ?>"/>

</div> <!--- end license section --->