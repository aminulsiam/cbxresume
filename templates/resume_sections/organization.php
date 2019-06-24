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
<?php do_action( 'cbxresume_details_organization_before', $resume_data ); ?>
	<div class="cbxresume_details_organization">
		<?php

		$resume_organization = isset( $resume['organization'] ) ? $resume['organization'] : array();

		if(empty($resume_organization)){
		    return false;
        }

        do_action( 'cbxresume_details_organization_start', $resume_data );
        ?>

		<h3><?php echo esc_html__( 'Organization', 'cbxresume' ); ?></h3>
		<ul>
			<?php


			foreach ( $resume_organization as $org ) {
				?>
				<li><?php esc_html_e( $org['name'] ) ?></li>
				<li><?php esc_html_e( $org['position_held'] ) ?></li>
				<li><?php esc_html_e( $org['assciated_with'] ) ?></li>
				<li><?php esc_html_e( $org['start_month'] ) ?></li>
				<li><?php esc_html_e( $org['start_year'] ) ?></li>
				<li><?php esc_html_e( $org['description'] ) ?></li>
			<?php } ?>
		</ul>

		<?php do_action( 'cbxresume_details_organization_end', $resume_data ); ?>
	</div>
<?php do_action( 'cbxresume_details_organization_after', $resume_data ); ?>