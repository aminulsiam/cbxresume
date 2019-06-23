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


$resume_patent = isset( $resumes['patent'] ) ?
	$resumes['patent'] : array();

if ( ! is_array( $resume_patent ) ) {
	$resume_patent = array();
}
?>

<h2><?php echo esc_html__( 'Patents', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_patent">

    <div class="cbxresume_patents">
		<?php
		if ( sizeof( $resume_patent ) > 0 ) {
			foreach ( $resume_patent as $key => $patent ) {
				?>
                <div class="cbxresume_patent">

                    <input type="text"
                           name="cbxresume[patent][<?php echo
					       esc_attr( $key ); ?>][title]"
                           value="<?php echo esc_attr__(
						       $patent['title'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[patent][<?php echo
					       esc_attr( $key ); ?>][office]"
                           value="<?php echo esc_attr__(
						       $patent['office'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[patent][<?php echo
					       esc_attr( $key ); ?>][application_number]"
                           value="<?php echo esc_attr__(
						       $patent['application_number'] ); ?>"/>


                    <select name="cbxresume[patent][<?php echo
					esc_attr( $key ); ?>][issue_month]">

						<?php
						foreach ( $cbxresume_month as $p => $p_month ) {
							?>
                            <option value="<?php echo esc_attr( $p ); ?>"
								<?php
								selected( $patent['issue_month'], $p ); ?>>

								<?php echo $p_month; ?>
                            </option>
						<?php } ?>
                    </select>

                    <select name="cbxresume[patent][<?php echo
					esc_attr( $key ); ?>][issue_day]">
						<?php
						for ( $i = 1; $i <= 31; $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $patent['issue_day'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>

                    <select name="cbxresume[patent][<?php echo
					esc_attr( $key ); ?>][issue_year]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $patent['issue_year'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>


                    <input type="text"
                           name="cbxresume[patent][<?php echo
					       esc_attr( $key ); ?>][patent_url]"
                           value="<?php echo esc_attr__(
						       $patent['patent_url'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[patent][<?php echo
					       esc_attr( $key ); ?>][description]"
                           value="<?php echo esc_attr__(
						       $patent['description'] ); ?>"/>


                    <a href="#" class="button cbxresume_patent_remove">
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

    <!-- Add new patent button -->
    <p>
        <a data-busy="0" href="#" class="button cbxresume_patent_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Patent', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get patent last count from db
	$patent_last_count = isset( $resumes['patent_last_count'] ) ?
		intval( $resumes['patent_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[patent_last_count]"
           class="cbxresume_patent_last_count"
           value="<?php echo esc_attr( $patent_last_count ); ?>"/>

</div> <!--- end patent section --->