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

$resume_honors_awards = isset( $resumes['honor_award'] ) ?
	$resumes['honor_award'] : array();

if ( ! is_array( $resume_honors_awards ) ) {
	$resume_honors_awards = array();
}
?>

<h2><?php echo esc_html__( 'Honors & Awards', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_honor_award">

	<div class="cbxresume_honor_awards">
		<?php
		if ( sizeof( $resume_honors_awards ) > 0 ) {
			foreach ( $resume_honors_awards as $key => $honors_award ) {
				?>
				<div class="cbxresume_honor_award">

					<input type="text"
					       name="cbxresume[honor_award][<?php echo
					       esc_attr( $key ); ?>][title]"
					       value="<?php echo esc_attr__(
						       $honors_award['title'] ); ?>"/>

					<input type="text"
					       name="cbxresume[honor_award][<?php echo
					       esc_attr( $key ); ?>][associated_with]"
					       value="<?php echo esc_attr__(
						       $honors_award['associated_with'] ); ?>"/>

					<input type="text"
					       name="cbxresume[honor_award][<?php echo
					       esc_attr( $key ); ?>][issuer]"
					       value="<?php echo esc_attr__(
						       $honors_award['issuer'] ); ?>"/>


					<select name="cbxresume[honor_award][<?php echo
					esc_attr( $key ); ?>][month]">

						<?php
						foreach ( $cbxresume_month as $p => $p_month ) {
							?>
							<option value="<?php echo esc_attr( $p ); ?>"
								<?php
								selected( $honors_award['month'], $p ); ?>>

								<?php echo $p_month; ?>
							</option>
						<?php } ?>
					</select>

					<select name="cbxresume[honor_award][<?php echo
					esc_attr( $key ); ?>][year]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
							<option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $honors_award['year'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
							</option>
						<?php } ?>
					</select>


					<input type="text"
					       name="cbxresume[honor_award][<?php echo
					       esc_attr( $key ); ?>][description]"
					       value="<?php echo esc_attr__(
						       $honors_award['description'] ); ?>"/>


					<a href="#" class="button cbxresume_honor_award_remove">
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
		<a data-busy="0" href="#" class="button cbxresume_honor_award_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php
			echo esc_html__( 'Add Honors & Awards', 'cbxresume' );
			?>
		</a>
	</p>

	<?php
	// Get honor & award last count from db
	$honor_award_last_count = isset( $resumes['honor_award_last_count']
	) ? intval( $resumes['honor_award_last_count'] ) : 0;
	?>

	<!-- cbx resume last count field -->
	<input type="hidden" name="cbxresume[honor_award_last_count]"
	       class="cbxresume_honor_award_last_count"
	       value="<?php echo esc_attr( $honor_award_last_count ); ?>"/>
</div> <!--- end honors & awards section --->