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

$language_proficiency = CBXResumeHelper::getLanguageProficiency();

$resume_language = isset( $resumes['language'] ) ?
	$resumes['language'] : array();

if ( ! is_array( $resume_language ) ) {
	$resume_language = array();
}
?>
<h2><?php echo esc_html__( 'Language', 'cbxresume' ); ?></h2>
<div class="cbxresume_section cbxresume_section_language">

    <div class="cbxresume_languages">
		<?php
		if ( sizeof( $resume_language ) > 0 ) {
			foreach ( $resume_language as $key => $language ) {
				?>
                <div class="cbxresume_language">
                    <input type="text"
                           name="cbxresume[language][<?php echo
					       esc_attr( $key ); ?>][language_name]"
                           value="<?php echo esc_attr__(
						       $language['language_name'] ); ?>"/>


                    <select name="cbxresume[language][<?php echo
					esc_attr( $key ); ?>][language_proficiency]">

						<?php
						foreach ( $language_proficiency as $p => $p_language ) {
							?>
                            <option value="<?php echo esc_attr( $p ); ?>"
								<?php selected( $language['language_proficiency'],
									$p ); ?>>

								<?php echo $p_language; ?>
                            </option>
						<?php } ?>
                    </select>


                    <a href="#" class="button cbxresume_language_remove">
                        <span class="dashicons dashicons-trash" style="margin-top: 3px;margin-bottom :10px;color: red;
"></span><?php echo esc_html__( 'Remove', 'cbxresume' ); ?></a>
                </div>
				<?php
			}
		}
		?>
    </div>

    <!-- Add new Language button -->
    <p>
        <a data-busy="0" href="#" class="button cbxresume_language_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
			<?php echo esc_html__( 'Add Language', 'cbxresume' ); ?>
        </a>
    </p>

	<?php
	// Get language last count from db
	$language_last_count = isset( $resumes['language_last_count'] ) ?
		intval( $resumes['language_last_count'] ) : 0;
	?>

    <!-- cbx resume last count field -->
    <input type="hidden" name="cbxresume[language_last_count]"
           class="cbxresume_language_last_count"
           value="<?php echo esc_attr( $language_last_count ); ?>"/>

</div> <!-- end cbxresume language section -->