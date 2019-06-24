<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://codeboxr.com
 * @since      1.0.7
 *
 * @package    cbxresume
 * @subpackage cbxresume/templates/resume_sections
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<?php do_action( 'cbxresume_details_language_before', $resume_data ); ?>
    <div class="cbxresume_details_language">
		<?php
		$resume_language = isset( $resume['language'] ) ? $resume['language'] : array();

		if(empty($resume_language)){
		    return false;
        }

		do_action( 'cbxresume_details_language_start', $resume_data );
		?>

        <h3><?php echo esc_html__( 'Language', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			foreach ( $resume_language as $language ) {
				?>
                <li><?php esc_html_e( $language['language_name'] . " : " . $language['language_proficiency'] ) ?></li>
			<?php } ?>
        </ul>
		<?php do_action( 'cbxresume_details_language_end', $resume_data ); ?>
    </div>
<?php do_action( 'cbxresume_details_language_after', $resume_data ); ?>