<?php
/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://codeboxr.com
 * @since      1.0.7
 *
 * @package    cbxwpsimpleaccountingvc
 * @subpackage cbxwpsimpleaccountingvc/admin/partials
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

global $wpdb;

$validation_errors_status = false;
$validation_errors        = array();
$invalid_fields           = array();

if ( array_key_exists( 'cbxresume_resume_validation_errors', $_SESSION ) ) {
	$validation_errors_status = true;
	$validation_errors        = $_SESSION['cbxresume_resume_validation_errors'];
	unset( $_SESSION['cbxresume_resume_validation_errors'] );

	if ( isset( $validation_errors['invalid_fields'] ) ) {
		$invalid_fields = $validation_errors['invalid_fields'];
	}
}

$data      = array();
$resume_id = 0;


if ( isset( $_GET['id'] ) && intval( $_GET['id'] ) > 0 ) {

	$resume_id = absint( $_GET['id'] );

	$cbxresume_educations = CBXResumeHelper::getCbxresumeData( $wpdb, $resume_id );
}


if ( sizeof( $invalid_fields ) > 0 ) {
	$data = array_merge( $data, $invalid_fields );
}

?>

<div class="wrap">
    <h2>
		<?php esc_html_e( 'CBX Resume', 'cbxresume' ); ?>
        <p>
			<?php echo '<a class="button button-primary button-large" href="' . admin_url( 'admin.php?page=cbxresumes' ) . '">' . esc_html__( 'Back to Store Listing',
					'cbxresume' ) . '</a>'; ?>

			<?php
			if ( $resume_id > 0 ) {
				echo '<a class="button" href="' . admin_url( 'admin.php?page=cbxresumes&view=addedit&id=0' ) . '">' . esc_attr__( 'Add New',
						'cbxresume' ) . '</a>';
			}
			?>
        </p>
    </h2>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h3><span><?php esc_html_e( 'Add/Edit Resume Information', 'cbxresume' ); ?></span>
                        </h3>
                        <div class="inside">

                            <div id="cbxresume_form_wrapper">
								<?php
								if ( isset( $_SESSION['cbxresume_resume_validation_success']['messages'] ) && sizeof( $_SESSION['cbxresume_resume_validation_success']['messages'] ) > 0 ) {
									echo '<div class="cbxresume_form_wrapper_success">';
									$messages = $_SESSION['cbxresume_resume_validation_success']['messages'];
									unset( $_SESSION['cbxresume_resume_validation_success'] );

									foreach ( $messages as $message ) {
										echo '<p class="success success-' . $message['type'] . '">' . $message['text'] . '</p>';
									}
									echo '</div>';
								}
								?>

								<?php if ( $validation_errors_status ) { ?>
                                    <div class="cbxresume_form_wrapper_error">
										<?php
										if ( array_key_exists( 'top_errors', $validation_errors ) ) {
											$top_errors = $validation_errors['top_errors'];
											if ( is_array( $top_errors ) && sizeof( $top_errors ) > 0 ) {
												foreach ( $top_errors as $key => $val ) {
													$val = array_values( $val );
													foreach ( $val as $error_text ) {
														echo '<p class="error error-danger" >' . $error_text . '</p>';
													}
												}
											}
										}
										?>
                                    </div>
								<?php } ?>

								<?php

								$cbxresume_education = isset( $cbxresume_educations['education'] ) ?
									$cbxresume_educations['education'] : array();

								if ( ! is_array( $cbxresume_education ) ) {
									$cbxresume_education = array();
								}

								?>

                                <form class="cbxresume_form"
                                      action="<?php echo admin_url( 'admin.php?page=cbxresumes&view=addedit&id=' . $resume_id ) ?>"
                                      method="post">

                                    <h2><?php echo esc_html__( 'Education ', 'cbxresume' ); ?></h2>
                                    <div id="cbxresume_sections">
                                        <div class="cbxresume_section cbxresume_section_education">

                                            <div class="cbxresume_educations">
												<?php
												if ( sizeof( $cbxresume_education ) > 0 ) {
													foreach ( $cbxresume_education as $key => $education ) {
														?>
                                                        <div class="cbxresume_education">
                                                            <input type="text"
                                                                   name="cbxresume[education][<?php echo
															       esc_attr( $key ); ?>][institute]"
                                                                   value="<?php echo esc_attr__(
																       $education['institute'] ); ?>"/>

                                                            <input type="text"
                                                                   name="cbxresume[education][<?php echo
															       esc_attr( $key ); ?>][degree]"
                                                                   value="<?php echo esc_attr__(
																       $education['degree'] ); ?>"/>

                                                            <input type="text"
                                                                   name="cbxresume[education][<?php echo
															       esc_attr( $key ); ?>][field]"
                                                                   value="<?php echo esc_attr__(
																       $education['field'] ); ?>"/>

                                                            <select name="cbxresume[education][<?php echo
															esc_attr( $key ); ?>][from]">
																<?php
																for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
																	?>
                                                                    <option value="<?php echo esc_attr( $i ) ?>"
																		<?php selected( $education['from'], $i ); ?>>
																		<?php echo esc_html( $i ); ?>
                                                                    </option>
																<?php } ?>
                                                            </select>

                                                            <select name="cbxresume[education][<?php echo
															esc_attr( $key ); ?>][to]">
																<?php
																for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
																	?>
                                                                    <option value="<?php echo esc_attr( $i ) ?>"
																		<?php selected( $education['to'], $i ); ?>>
																		<?php echo esc_html( $i ); ?>
                                                                    </option>
																<?php } ?>
                                                            </select>

                                                            <input type="text" name="cbxresume[education][<?php echo
															esc_attr( $key ); ?>][grade]"
                                                                   value="<?php echo esc_attr__(
																       $education['grade'] ); ?>"/>

                                                            <input type="text"
                                                                   name="cbxresume[education][<?php echo
															       esc_attr( $key ); ?>][activity]"
                                                                   value="<?php echo esc_attr__(
																       $education['activity'] ); ?>"/>

                                                            <input type="text"
                                                                   name="cbxresume[education][<?php echo
															       esc_attr( $key ); ?>][description]"
                                                                   value="<?php echo esc_attr__(
																       $education['description'] ); ?>"/>

                                                            <a href="#" class="button cbxresume_education_remove">
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

                                            <p>
                                                <a data-busy="0" href="#" class="button cbxresume_education_add">
                                                    <span class="dashicons dashicons-plus-alt" style="margin-top:
                                                    3px;color: #0baf63;"></span>
													<?php echo esc_html__( 'Add New', 'cbxresume' ); ?>
                                                </a>
                                            </p>

											<?php
											// Get education last count from db
											$education_last_count = isset( $cbxresume_educations['last_count'] ) ?
												intval( $cbxresume_educations['last_count'] ) : 0;
											?>

                                            <!-- cbx resume last count field -->
                                            <input type="hidden" name="cbxresume[last_count]"
                                                   class="cbxresume_last_count"
                                                   value="<?php echo esc_attr( $education_last_count ); ?>"/>
                                        </div>
                                    </div>

                                    <div class="cbxresume_fields">
										<?php if ( $validation_errors_status ) { ?>
											<?php if ( array_key_exists( 'name', $validation_errors ) ) {
												echo '<p for="cbxresume_field_name" class="error">' . ( $validation_errors['name'] ) . '</p>';
											} ?>
										<?php } ?>
                                    </div>

                                    <input type="hidden" name="resume_id" value="<?php echo intval( $resume_id ); ?>"/>

									<?php wp_nonce_field( 'cbxresume_token', 'cbxresume_nonce' ); ?>

                                    <button type="submit" name="cbxresume_resume_edit" style="margin-top: 15px;"
                                            class="button-primary "><?php echo ( $resume_id == 0 ) ? esc_html__( 'Add Store',
											'cbxresume' ) : esc_html__( 'Update Store', 'cbxresume' ); ?></button>
                                </form>
                            </div>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                </div> <!-- .meta-box-sortables .ui-sortable -->
            </div> <!-- post-body-content -->
			<?php
			//include('sidebar.php');
			?>
        </div> <!-- #post-body .metabox-holder .columns-2 -->
        <div class="clear"></div>
    </div> <!-- #poststuff -->
</div> <!-- .wrap -->