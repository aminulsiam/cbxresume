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

$resume_publication = isset( $resumes['publication'] ) ?
	$resumes['publication'] : array();

if ( ! is_array( $resume_publication ) ) {
	$resume_publication = array();
}

$cbxresume_month = CBXResumeHelper::getResumeMonth();
?>

<h2><?php echo esc_html__( 'Publication', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_publication">

	<div class="cbxresume_publications">
		<?php
		if ( sizeof( $resume_publication ) > 0 ) {
			foreach ( $resume_publication as $key => $publication ) {
				?>
				<div class="cbxresume_publication">

					<input type="text"
					       name="cbxresume[publication][<?php echo
					       esc_attr( $key ); ?>][title]"
					       value="<?php echo
					       esc_attr__( $publication['title'] ); ?>"/>

					<input type="text"
					       name="cbxresume[publication][<?php echo
					       esc_attr( $key ); ?>][publisher]"
					       value="<?php echo
					       esc_attr__( $publication['publisher'] ); ?>"/>


					<select name="cbxresume[publication][<?php echo
					esc_attr( $key ); ?>][year]">
						<?php
						for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
							?>
							<option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $publication['year'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
							</option>
						<?php } ?>
					</select>

					<select name="cbxresume[publication][<?php echo
					esc_attr( $key ); ?>][month]">

						<?php
						foreach ( $cbxresume_month as $p => $p_month ) {
							?>
							<option value="<?php echo esc_attr( $p ); ?>"
								<?php
								selected( $publication['month'], $p ); ?>>

								<?php echo $p_month; ?>
							</option>
						<?php } ?>
					</select>


					<select name="cbxresume[publication][<?php echo
					esc_attr( $key ); ?>][day]">
						<?php
						for ( $i = 1; $i <= 31; $i ++ ) {
							?>
							<option value="<?php echo esc_attr( $i ) ?>"
								<?php selected( $publication['day'], $i ); ?>>
								<?php echo esc_html( $i ); ?>
							</option>
						<?php } ?>
					</select>

					<input type="text"
					       name="cbxresume[publication][<?php echo
					       esc_attr( $key ); ?>][writter]"
					       value="<?php echo
					       esc_attr__( $publication['writter'] ); ?>"/>

					<input type="text"
					       name="cbxresume[publication][<?php echo
					       esc_attr( $key ); ?>][publication_url]"
					       value="<?php echo
					       esc_attr__( $publication['publication_url'] ); ?>"/>

					<input type="text"
					       name="cbxresume[publication][<?php echo
					       esc_attr( $key ); ?>][description]"
					       value="<?php echo
					       esc_attr__( $publication['description'] ); ?>"/>


					<a href="#" class="button cbxresume_publication_remove">
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

	<!-- Add new publication button -->
	<p>
		<a data-busy="0" href="#" class="button cbxresume_publication_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Publication', 'cbxresume' ); ?>
		</a>
	</p>

	<?php
	// Get publication last count from db
	$publication_last_count = isset( $resumes['publication_last_count'] ) ?
		intval( $resumes['publication_last_count'] ) : 0;
	?>

	<!-- cbx resume last count field -->
	<input type="hidden" name="cbxresume[publication_last_count]"
	       class="cbxresume_publication_last_count"
	       value="<?php echo esc_attr( $publication_last_count ); ?>"/>

</div> <!-- end cbxresume publication section -->