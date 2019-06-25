<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    CBXResume
 * @subpackage CBXResume/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CBXResume
 * @subpackage CBXResume/public
 * @author     Codeboxr <info@codeboxr.com>
 */
class CBXResume_Public {

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


	private $setting;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->setting = new CBXResumeSettings();
	}


	/**
	 *
	 */
	public function init_register_widgets() {
		register_widget( 'CBXBusinessHoursFrontWidget' );
	}// end of init_register_widgets method


	/**
	 * Init all shortcodes
	 */
	public function init_shortcode() {
		add_shortcode( 'cbxresume', array( $this, 'cbxresume_shortcode' ) );
	}//end method init_shortcode


	/**
	 * Shortcode [cbxresume] callback.
	 *
	 * @param $atts
	 *
	 * @return string|void
	 */
	public function cbxresume_shortcode( $atts ) {

		$atts = shortcode_atts( array(
			'id'       => '',
			'sections' => '',
		), $atts, 'cbxresume' );

		$id = intval( $atts['id'] );

		$sections =  explode(',',$atts['sections']);

		$resume_data = CBXResumeHelper::getResumeData( $id, $sections );

		if ( $resume_data !== null ) {
			return CBXResumeHelper::displayResumeHtml( $resume_data, $sections );
		} else {
			return '';
		}
	}//end method cbxresume_shortcode


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style( 'cbxbusinesshours-public',
			plugin_dir_url( __FILE__ ) . '../assets/css/cbxbusinesshours-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

	}//end method enqueue_scripts


}//end class CBXResume_Public
