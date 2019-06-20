<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    CBXBusinessHours
 * @subpackage CBXBusinessHours/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CBXBusinessHours
 * @subpackage CBXBusinessHours/admin
 * @author     Codeboxr <info@codeboxr.com>
 */
class CBXResume_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		//get plugin base file name
		$this->plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $plugin_name . '.php' );

		$this->settings = new CBXResumeSettings();
	}


	/**
	 * Initialized settings api
	 * Author - @tareq_hasan
	 */
	public function settings_init() {
		//set the settings
		$this->settings->set_sections( $this->get_settings_sections() );
		$this->settings->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings->admin_init();
	}


	public function get_settings_sections() {
		$sections = array(
			array(
				'id'    => 'cbxresume_general',
				'title' => esc_html__( 'General', 'cbxresume' )
			),
			array(
				'id'    => 'cbxresume_primary',
				'title' => esc_html__( 'Primary', 'cbxresume' )
			),
		);

		//return $sections;
		return apply_filters( 'cbxresume_setting_sections', $sections );
	}//end method get_settings_sections

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	public function get_settings_fields() {
		$settings_builtin_fields = array(
			'cbxresume_general' => array(
				array(
					'name'                                           => 'text_val',
					'label'                                          => __( 'Text Input', 'cbxresume' ),
					'desc'                                           => __( 'Text input description', 'cbxresume' ),
					'placbxresume_resume_edit_add_educationceholder' => __( 'Text Input placeholder', 'cbxresume' ),
					'type'                                           => 'text',
					'default'                                        => 'Title',
					'sanitize_callback'                              => 'sanitize_text_field'
				)
			),
			'cbxresume_primary' => array(
				array(
					'name'              => 'text_val',
					'label'             => __( 'Text Input', 'wedevs' ),
					'desc'              => __( 'Text input description', 'cbxresume' ),
					'placeholder'       => __( 'Text Input placeholder', 'cbxresume' ),
					'type'              => 'textarea',
					'default'           => 'Title',
					'sanitize_callback' => 'sanitize_text_field'
				)
			),

		);

		$settings_fields = array(); //final setting array that will be passed to different filters

		$sections = $this->get_settings_sections();

		foreach ( $sections as $section ) {
			if ( ! isset( $settings_builtin_fields[ $section['id'] ] ) ) {
				$settings_builtin_fields[ $section['id'] ] = array();
			}
		}

		foreach ( $sections as $section ) {
			$settings_fields[ $section['id'] ] = apply_filters( 'cbxresume_global_' . $section['id'] . '_fields',
				$settings_builtin_fields[ $section['id'] ] );
		}

		$settings_fields = apply_filters( 'cbxresume_global_fields', $settings_fields ); //final filter if need

		return $settings_fields;

	}//end method get_settings_fields


	/**
	 * Create admin menu for this plugin .
	 */
	public function create_admin_menu() {

		if ( ! session_id() ) {
			session_start();
		}

		$root_menu_hook = add_menu_page(
			esc_html__( 'CBX Resumes', 'cbxresume' ),
			esc_html__( 'CBX Resumes', 'cbxresume' ),
			'manage_options',
			'cbxresumes',
			array( $this, 'display_resume_listing_page' )
		);

		add_submenu_page(
			'cbxresumes',
			esc_html__( 'CBX Resume settings', 'cbxresume' ),
			esc_html__( 'Settings', 'cbxresume' ),
			'manage_options',
			'cbxresume_settings',
			array( $this, 'display_resume_submenu_page' )
		);

	} // end method create_admin_menu


	/**
	 * Init all shortcodes
	 */
	public function init_shortcode() {
		add_shortcode( 'cbxresume', array( $this, 'cbxresume_shortcode' ) );
	} // end method init_shortcode


	/**
	 * shortcode [cbxresume] callback.
	 *
	 * @param $atts
	 */
	public function cbxresume_shortcode( $atts ) {

		global $wpdb;

		$atts = shortcode_atts( array(
			'id' => '',
		), $atts, 'cbxresume' );

		$cbxresume_data = CBXResumeHelper::getResumeData( $wpdb, $atts );

		$display_resume_data = CBXResumeHelper::displayResumeData( $cbxresume_data );

		return $display_resume_data;

	} // end method cbxresume_shortcode


	/**
	 * Submenu callback @function
	 *
	 * This function gives the output of submenu
	 */
	public function display_resume_submenu_page() {

		global $wpdb;

		$plugin_data = get_plugin_data( plugin_dir_path( __DIR__ ) . '/../' . $this->plugin_basename );

		include( cbxresume_locate_template( 'admin/setting.php' ) );
	}

	/**
	 * Admin menu callback function
	 *
	 * This function gives the output of cbxresume admin menu .
	 *
	 */
	public function display_resume_listing_page() {

		if ( isset( $_GET['view'] ) && $_GET['view'] == 'addedit' ) {
			include( cbxresume_locate_template( 'admin/add.php' ) );

		} elseif ( isset( $_GET['view'] ) && $_GET['view'] == 'view' ) {
			include( cbxresume_locate_template( 'admin/view.php' ) );
		} else {
			CBXResumeHelper::displayResumeTableList();
		}

	} // end method adminMenuCallback


	/**
	 * Store form submit and Save data
	 */
	public function resume_submit() {
		if ( isset( $_POST['cbxresume_resume_edit'] ) ) {

			global $wpdb;

			$page_url = admin_url( 'admin.php?page=cbxresumes&view=addedit' );

			//check_admin_referer( 'cbxresume_token', 'cbxresume_nonce' );
			if ( wp_verify_nonce( $_POST['cbxresume_nonce'], 'cbxresume_token' ) ) {

				global $wpdb;
				$cbxresume_table = $wpdb->prefix . "cbxresumes";

				$current_user = wp_get_current_user();
				$user_id      = $current_user->ID;
				$post_data    = $_POST;

				$resume_id = isset( $post_data['resume_id'] ) ? intval( $post_data['resume_id'] ) : 0;

				$cbxresume_data = $post_data['cbxresume'];

				// validation
				$validation_errors = array();
				$invalid_fields    = array();

				/*if ( $institute == '' ) {
					$validation_errors['title'] = esc_html__( 'Store name empty', 'cbxresume' );
					$invalid_fields['title']    = $institute;
				} elseif ( $institute_length < 5 ) {
					$validation_errors['title'] = esc_html__( 'Store name must be minimum 5 character long',
						'cbxresume' );
					$invalid_fields['title']    = $institute;
				}*/

				if ( sizeof( $invalid_fields ) > 0 ) {
					$validation_errors['invalid_fields'] = $invalid_fields;
				}

				$validation_errors = apply_filters( 'cbxresume_resume_validation_errors', $validation_errors,
					$post_data, $resume_id );


				if ( sizeof( $validation_errors ) > 0 ) {
					$_SESSION['cbxresume_resume_validation_errors'] = $validation_errors;

					$page_url = add_query_arg( array( 'id' => $resume_id ), $page_url );
					wp_safe_redirect( $page_url );
					exit;
				}


				$messages            = array();
				$success_arr         = array();
				$data_safe           = array();
				$data_safe['resume'] = maybe_serialize( $cbxresume_data );

				if ( $resume_id > 0 ) {
					//update
					$data_safe['mod_by']   = $user_id;
					$data_safe['mod_date'] = current_time( 'mysql' );

					$data_safe = apply_filters( 'cbxresume_resume_data_before_update', $data_safe, $resume_id );

					$where = array(
						'id' => $resume_id,
					);

					$where = apply_filters( 'cbxresume_resume_where_before_update', $where, $data_safe,
						$resume_id );

					$where_format = array( '%d' );
					$where_format = apply_filters( 'cbxresume_resume_where_format_before_update',
						$where_format, $data_safe, $resume_id );


					$data_format = array(
						'%s', // weekdays
						'%d', // mod_by
						'%s'  // mod_date
					);

					$data_format = apply_filters( 'cbxresume_resume_data_format_before_update', $data_format,
						$data_safe, $resume_id );

					if ( $wpdb->update( $cbxresume_table, $data_safe, $where, $data_format,
							$where_format ) !== false ) {
						do_action( 'cbxresume_resume_after_update', $data_safe, $resume_id );

						$message    = array(
							'text' => esc_html__( 'Resume updated successfully', 'cbxresume' ),
							'type' => 'success'
						);
						$messages[] = $message;
					} else {
						//failed to insert
						$message    = array(
							'text' => esc_html__( 'Sorry! Failed to update', 'cbxresume' ),
							'type' => 'danger'
						);
						$messages[] = $message;
					}

				}//end update mode
				else {
					//insert

					$data_safe['add_by']   = $user_id;
					$data_safe['add_date'] = current_time( 'mysql' );

					$data_safe = apply_filters( 'cbxresume_resume_data_before_insert', $data_safe, $resume_id );

					$data_format = array(
						'%s', // cbxresume
						'%d', //add_by
						'%s', ///add_date
					);

					$data_format = apply_filters( 'cbxresume_resume_data_format_before_insert', $data_format,
						$data_safe, $resume_id );

					do_action( 'cbxresume_resume_before_insert', $data_safe, $resume_id );

					if ( $wpdb->insert( $cbxresume_table, $data_safe, $data_format ) !== false ) {
						$resume_id = $wpdb->insert_id;

						$data_safe['id'] = $resume_id;

						do_action( 'cbxresume_resume_after_insert', $data_safe, $resume_id );

						$message = array(
							'text' => esc_html__( 'Resume added successfully', 'cbxresume' ),
							'type' => 'success'
						);

						$messages[] = $message;

					} else {
						//failed to insert
						$message    = array(
							'text' => esc_html__( 'Sorry! Failed to insert', 'cbxresume' ),
							'type' => 'danger'
						);
						$messages[] = $message;
					}

					$messages = apply_filters( 'cbxresume_resume_validation_success_messages', $messages,
						$data_safe, $resume_id );

				}//end insert mode

				$success_arr['messages']                         = $messages;
				$_SESSION['cbxresume_resume_validation_success'] = $success_arr;

				$page_url = add_query_arg( array( 'id' => $resume_id, ), $page_url );

				wp_safe_redirect( $page_url );
				exit;
			}
		}
	}//end method resume_submit


	/**
	 * Add new education template
	 */
	public function cbxresume_resume_edit_add_education() {
		$output = array();

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output['field'] = CBXResumeHelper::resumeAdd_Education_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	}//end method cbxresume_resume_edit_add_education


	/**
	 * Add new experience template
	 */
	public function cbxresume_resume_edit_add_experience() {
		$output = array();

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output['field'] = CBXResumeHelper::resumeAdd_Experience_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_experience


	/**
	 * Add new language template
	 */
	public function cbxresume_resume_edit_add_language() {
		$output = array();

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output['field'] = CBXResumeHelper::resumeAdd_Language_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_language


	/**
	 * Add new license and certificates template
	 */
	public function cbxresume_resume_edit_add_license() {
		$output = array();

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output['field'] = CBXResumeHelper::resumeAdd_License_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_license


	/**
	 * Add new volunteer template
	 */
	public function cbxresume_resume_edit_add_volunteer() {
		$output = array();

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output['field'] = CBXResumeHelper::resumeAdd_Volunteer_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_volunteer


	/**
	 * Add new skill template
	 */
	public function cbxresume_resume_edit_add_skill() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_Skill_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_skill


	/**
	 * Add new publication template
	 */
	public function cbxresume_resume_edit_add_publication() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_publication_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_publication


	/**
	 * Add new course template
	 */
	public function cbxresume_resume_edit_add_course() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_Course_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_course


	/**
	 * Add new project template
	 */
	public function cbxresume_resume_edit_add_project() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_Project_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_project

	/**
	 * Add new honors & awards template
	 */
	public function cbxresume_resume_edit_add_honor_award() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_Honors_Awards_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_honors_award


	/**
	 * Add new test score template.
	 */
	public function cbxresume_resume_edit_add_test_score() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_Test_Score_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_test_score


	/**
	 * Add new organization template.
	 */
	public function cbxresume_resume_edit_add_organization() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_Organization_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_organization


	/**
	 * Add new patent template.
	 */
	public function cbxresume_resume_edit_add_patent() {

		$last_count_val = isset( $_POST['last_count'] ) ? intval( $_POST['last_count'] ) : 0;

		$output = array();

		$output['field'] = CBXResumeHelper::resumeAdd_patent_Field( $last_count_val );

		echo json_encode( $output );

		exit();

	} // end method cbxresume_resume_edit_add_organization


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : '';

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_register_style( 'cbxresume-admin', plugin_dir_url( __FILE__ ) . '../assets/css/cbxresume-admin.css', array(),
			$this->version, 'all' );

		if ( $page == 'cbxresume_settings' ) {
			wp_register_style( 'select2', plugin_dir_url( __FILE__ ) . '../assets/select2/css/select2.min.css',
				array(), $this->version );

			//wp_register_style( 'jquery-timepicker', plugin_dir_url( __FILE__ ) . '../assets/css/jquery.timepicker.min.css', array(), $this->version,'all' );

			//wp_register_style( 'jquery-ui', plugin_dir_url( __FILE__ ) . '../assets/css/jquery-ui.css', array(),$this->version, 'all' );

			wp_register_style( 'cbxresume-settings',
				plugin_dir_url( __FILE__ ) . '../assets/css/cbxresume-settings.css', array(
					'select2',
					//'jquery-timepicker',
					//'jquery-ui',
					'wp-color-picker'
				), $this->version, 'all' );

			wp_enqueue_style( 'select2' );
			//wp_enqueue_style( 'jquery-timepicker' );
			//wp_enqueue_style( 'jquery-ui' );
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style( 'cbxresume-settings' );
		}
	}//end method enqueue_styles

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : '';

		$current_screen = get_current_screen();

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		if ( $page == 'cbxresume_settings' ) {


			wp_register_script( 'select2', plugin_dir_url( __FILE__ ) . '../assets/select2/js/select2.min.js',
				array( 'jquery' ), $this->version, true );

			//wp_register_script( 'jquery-timepicker',plugin_dir_url( __FILE__ ) . '../assets/js/jquery.timepicker.min.js', array( 'jquery' ), $this->version, true );
			wp_register_script( 'cbxresume-settings', plugin_dir_url( __FILE__ ) . '../assets/js/cbxresume-settings.js',
				array(
					'jquery',
					'select2',
					//'jquery-timepicker',
					//'jquery-ui-datepicker',
					'wp-color-picker'
				), $this->version, true );


			// Localize the script with translation
			$translation_placeholder = apply_filters( 'cbxresume_setting_js_vars', array() );

			wp_localize_script( 'cbxresume-settings', 'cbxresume_setting', $translation_placeholder );


			wp_enqueue_script( 'jquery' );
			wp_enqueue_media();
			wp_enqueue_script( 'select2' );
			//wp_enqueue_script( 'jquery-timepicker' );
			//wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'cbxresume-settings' );
		}

		if ( $page == "cbxresumes" ) {

			wp_register_script( 'cbxresume-admin', plugin_dir_url( __FILE__ ) . '../assets/js/cbxresume-admin.js',
				array( 'jquery' ), time(), true );


			wp_enqueue_script( 'cbxresume-admin' );


			$localzed_value = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			);

			wp_localize_script( 'cbxresume-admin', 'cbxresume_admin', $localzed_value );

		}

	}//end method enqueue_scripts


}//end class CbxBusinessHours_Admin
