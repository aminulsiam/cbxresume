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
<?php do_action( 'cbxresume_details_skill_before', $resume_data ); ?>
    <div class="cbxresume_details_skill">
		<?php
		$resume_skill = isset( $resume['skill'] ) ? $resume['skill'] : array();

		if ( empty( $resume_skill ) ) {
			return false;
		}

		do_action( 'cbxresume_details_skill_start', $resume_data );

		?>

        <h3><?php echo esc_html__( 'Skill', 'cbxresume' ); ?></h3>
        <ul>
			<?php


			foreach ( $resume_skill as $skill ) {
				?>
                <li><?php esc_html_e( $skill ) ?></li>
			<?php } ?>
        </ul>

		<?php do_action( 'cbxresume_details_skill_end', $resume_data ); ?>
    </div>
<?php do_action( 'cbxresume_details_skill_after', $resume_data ); ?>