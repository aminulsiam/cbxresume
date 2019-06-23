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

$resume_project = isset( $resumes['project'] ) ?
	$resumes['project'] : array();

if ( ! is_array( $resume_project ) ) {
	$resume_project = array();
}
?>

<h2><?php echo esc_html__( 'Projects', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_project">

    <div class="cbxresume_projects">
		<?php
		if ( sizeof( $resume_project ) > 0 ) {
			foreach ( $resume_project as $key => $project ) {
				?>
                <div class="cbxresume_project">

                    <input type="text"
                           name="cbxresume[project][<?php echo
					       esc_attr( $key ); ?>][project_name]"
                           value="<?php echo esc_attr__(
						       $project['project_name'] ); ?>"/>


                    <select name="cbxresume[project][<?php echo
					esc_attr( $key ); ?>][month]">

						<?php
						foreach ( $cbxresume_month as $p => $p_month ) {
							?>
                            <option value="<?php echo esc_attr( $p ); ?>"
								<?php
								selected( $project['month'], $p ); ?>>

								<?php echo $p_month; ?>
                            </option>
						<?php } ?>
                    </select>

                    <select name="cbxresume[project][<?php echo
					esc_attr( $key ); ?>][year]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $project['year'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>


                    <input type="text"
                           name="cbxresume[project][<?php echo
					       esc_attr( $key ); ?>][project_url]"
                           value="<?php echo esc_attr__(
						       $project['project_url'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[project][<?php echo
					       esc_attr( $key ); ?>][associated_with]"
                           value="<?php echo esc_attr__(
						       $project['associated_with'] ); ?>"/>

                    <a href="#" class="button cbxresume_project_remove">
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
        <a data-busy="0" href="#" class="button cbxresume_project_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Project', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get license last count from db
	$project_last_count = isset( $resumes['project_last_count'] ) ?
		intval( $resumes['project_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[project_last_count]"
           class="cbxresume_project_last_count"
           value="<?php echo esc_attr( $project_last_count ); ?>"/>

</div> <!--- end project section --->