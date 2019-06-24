<?php
/**
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
<?php do_action( 'cbxresume_details_experience_before', $resume_data ); ?>
    <div class="cbxresume_details_experience">

		<?php
		$resume_experience = isset( $resume['experience'] ) ? $resume['experience'] : array();

		if ( empty( $resume_experience ) ) {
			return false;
		}

		do_action( 'cbxresume_details_experience_start', $resume_data );

		?>

        <h3><?php echo esc_html__( 'Experience', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			foreach ( $resume_experience as $experience ) {
				?>
                <li><?php esc_html_e( $experience['title'] ) ?></li>
                <li><?php esc_html_e( $experience['company'] ) ?></li>
                <li><?php esc_html_e( $experience['start_date'] ) ?></li>
                <li><?php esc_html_e( $experience['description'] ) ?></li>
			<?php } ?>
        </ul>

		<?php do_action( 'cbxresume_details_experience_end', $resume_data ); ?>

    </div>
<?php do_action( 'cbxresume_details_experience_after', $resume_data ); ?>