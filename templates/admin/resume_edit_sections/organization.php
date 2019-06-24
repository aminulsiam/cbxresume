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

$resume_organization = isset( $resumes['organization'] ) ?
	$resumes['organization'] : array();

if ( ! is_array( $resume_organization ) ) {
	$resume_organization = array();
}
?>

<h2><?php echo esc_html__( 'Organization', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_organization">

    <div class="cbxresume_organizations">
		<?php
		if ( sizeof( $resume_organization ) > 0 ) {
			foreach ( $resume_organization as $key => $org ) {
				?>
                <div class="cbxresume_organization">

                    <input type="text"
                           name="cbxresume[organization][<?php echo
					       esc_attr( $key ); ?>][name]"
                           value="<?php echo
					       esc_attr__( $org['name'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[organization][<?php echo
					       esc_attr( $key ); ?>][position_held]"
                           value="<?php echo
					       esc_attr__( $org['position_held'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[organization][<?php echo
					       esc_attr( $key ); ?>][assciated_with]"
                           value="<?php echo
					       esc_attr__( $org['assciated_with'] ); ?>"/>


                    <select name="cbxresume[organization][<?php echo
					esc_attr( $key ); ?>][start_month]">

						<?php
						foreach ( $cbxresume_month as $p => $p_month ) {
							?>
                            <option value="<?php echo esc_attr( $p ); ?>"
								<?php
								selected( $org['start_month'], $p ); ?>>

								<?php echo $p_month; ?>
                            </option>
						<?php } ?>
                    </select>

                    <select name="cbxresume[organization][<?php echo
					esc_attr( $key ); ?>][start_year]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $org['start_year'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>


                    <input type="text"
                           name="cbxresume[organization][<?php echo
					       esc_attr( $key ); ?>][description]"
                           value="<?php echo
					       esc_attr__( $org['description'] ); ?>"/>

                    <a href="#" class="button cbxresume_organization_remove">
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

    <!-- Add new test score button -->
    <p>
        <a data-busy="0" href="#" class="button cbxresume_organization_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Organization',
				'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get organization last count from db
	$test_score_last_count = isset( $resumes['organization_last_count'] ) ?
		intval( $resumes['organization_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[organization_last_count]"
           class="cbxresume_organization_last_count"
           value="<?php echo esc_attr( $test_score_last_count ); ?>"/>

</div> <!-- end cbxresume test score section -->