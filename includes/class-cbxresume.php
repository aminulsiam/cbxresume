<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    CBXBusinessHours
 * @subpackage CBXBusinessHours/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    CBXBusinessHours
 * @subpackage CBXBusinessHours/includes
 * @author     Codeboxr <info@codeboxr.com>
 */
class CBXResume {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      CBXBusinessHours_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = CBXRESUME_PLUGIN_NAME;
		$this->version     = CBXRESUME_PLUGIN_VERSION;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - CBXResume_Loader. Orchestrates the hooks of the plugin.
	 * - CBXResume_i18n. Defines internationalization functionality.
	 * - CBXResume_Admin. Defines all hooks for the admin area.
	 * - CBXResume_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cbxresume-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cbxresume-i18n.php';

		/**
		 * Setting Class Api will be helpful for creating options page setting section
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cbxresume-settings.php';

		/**
		 * Helper class
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cbxresume-functions.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cbxresume-helper.php';


		/**
		 * Front end display widgets file
		 */
		//require_once plugin_dir_path(dirname(__FILE__)) . 'widgets/class-cbxresume-front_widget.php';


		/**
		 * Dashboard widget class
		 */
		//require_once plugin_dir_path(dirname(__FILE__)) . 'widgets/class-cbxresume-dashboard-widget.php';

		/**
		 * Custom Elementor widget for cbx business hours plugin
		 */

		//require_once plugin_dir_path(dirname(__FILE__)) . 'widgets/class-cbxbusinesshours-elementor.php';


		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cbxresume-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cbxresume-public.php';

		$this->loader = new CBXResume_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the CBXBusinessHours_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new CBXResume_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new CBXResume_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_init' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'resume_submit' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action('wp_ajax_cbxresume_resume_edit_add_education',$plugin_admin,
			'cbxresume_resume_edit_add_education');

		$this->loader->add_action('wp_ajax_cbxresume_resume_edit_add_experience',$plugin_admin,
			'cbxresume_resume_edit_add_experience');

		$this->loader->add_action('wp_ajax_cbxresume_resume_edit_add_language',$plugin_admin,
			'cbxresume_resume_edit_add_language');

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new CBXResume_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );


	}// end of define_public_hooks methods

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    CBXResume_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

}// end of CBXResume class
