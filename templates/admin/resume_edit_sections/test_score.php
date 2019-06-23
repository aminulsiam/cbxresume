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

$resume_test_score = isset( $resumes['test_score'] ) ?
	$resumes['test_score'] : array();

if ( ! is_array( $resume_test_score ) ) {
	$resume_test_score = array();
}
?>

<h2><?php echo esc_html__( 'Test Score', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_test_score">

    <div class="cbxresume_test_scores">
		<?php
		if ( sizeof( $resume_test_score ) > 0 ) {
			foreach ( $resume_test_score as $key => $test_score ) {
				?>
                <div class="cbxresume_test_score">

                    <input type="text"
                           name="cbxresume[test_score][<?php echo
					       esc_attr( $key ); ?>][test_name]"
                           value="<?php echo
					       esc_attr__( $test_score['test_name'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[test_score][<?php echo
					       esc_attr( $key ); ?>][associated_with]"
                           value="<?php echo
					       esc_attr__( $test_score['associated_with'] ); ?>"/>

                    <input type="text"
                           name="cbxresume[test_score][<?php echo
					       esc_attr( $key ); ?>][score]"
                           value="<?php echo
					       esc_attr__( $test_score['score'] ); ?>"/>

                    <select name="cbxresume[test_score][<?php echo
					esc_attr( $key ); ?>][month]">

						<?php
						foreach ( $cbxresume_month as $p => $p_month ) {
							?>
                            <option value="<?php echo esc_attr( $p ); ?>"
								<?php
								selected( $test_score['month'], $p ); ?>>

								<?php echo $p_month; ?>
                            </option>
						<?php } ?>
                    </select>

                    <select name="cbxresume[test_score][<?php echo
					esc_attr( $key ); ?>][year]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
                            <option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $test_score['year'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
                            </option>
						<?php } ?>
                    </select>


                    <input type="text"
                           name="cbxresume[test_score][<?php echo
					       esc_attr( $key ); ?>][description]"
                           value="<?php echo
					       esc_attr__( $test_score['description'] ); ?>"/>

                    <a href="#" class="button cbxresume_test_score_remove">
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
        <a data-busy="0" href="#" class="button cbxresume_test_score_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Test Score', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get language last count from db
	$test_score_last_count = isset( $resumes['test_score_last_count'] ) ?
		intval( $resumes['test_score_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[test_score_last_count]"
           class="cbxresume_test_score_last_count"
           value="<?php echo esc_attr( $test_score_last_count ); ?>"/>

</div> <!-- end cbxresume test score section -->