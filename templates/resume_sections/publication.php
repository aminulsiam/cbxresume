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
<?php do_action( 'cbxresume_details_publication_before', $resume_data ); ?>
    <div class="cbxresume_details_publication">
		<?php

		$resume_publication = isset( $resume['publication'] ) ? $resume['publication'] : array();

		if ( empty( $resume_publication ) ) {
			return false;
		}

		do_action( 'cbxresume_details_publication_start', $resume_data );
		?>

        <h3><?php echo esc_html__( 'Publication', 'cbxresume' ); ?></h3>
        <ul>
			<?php

			foreach ( $resume_publication as $publication ) {
				?>
                <li><?php esc_html_e( $publication['title'] ) ?></li>
                <li><?php esc_html_e( $publication['publisher'] ) ?></li>
                <li><?php esc_html_e( $publication['year'] ) ?></li>
                <li><?php esc_html_e( $publication['month'] ) ?></li>
                <li><?php esc_html_e( $publication['day'] ) ?></li>
                <li><?php esc_html_e( $publication['writter'] ) ?></li>
                <li><?php esc_html_e( $publication['publication_url'] ) ?></li>
                <li><?php esc_html_e( $publication['description'] ) ?></li>
			<?php } ?>
        </ul>

		<?php do_action( 'cbxresume_details_publication_end', $resume_data ); ?>
    </div>
<?php do_action( 'cbxresume_details_publication_after', $resume_data ); ?>