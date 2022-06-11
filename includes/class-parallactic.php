<?php
use PHPMailer\PHPMailer\PHPMailer;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       paralactic.ch
 * @since      1.0.0
 *
 * @package    Parallactic
 * @subpackage Parallactic/includes
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
 * @package    Parallactic
 * @subpackage Parallactic/includes
 * @author     Parallactic GmbH <mail@parallactic.ch>
 */
class Parallactic {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Parallactic_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
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
		if ( defined( 'PARALLACTIC_VERSION' ) ) {
			$this->version = PARALLACTIC_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'parallactic';

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
	 * - Parallactic_Loader. Orchestrates the hooks of the plugin.
	 * - Parallactic_i18n. Defines internationalization functionality.
	 * - Parallactic_Admin. Defines all hooks for the admin area.
	 * - Parallactic_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-parallactic-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-parallactic-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-parallactic-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-parallactic-public.php';

		/**
		 * The class responsible for all SEO features
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-parallactic-meta.php';

		/**
		 * The class responsible close security vulnerability
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-parallactic-security.php';

		/**
		 * The class responsible for all content fields for pages
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-parallactic-page.php';

		/**
		 * The class responsible to attach all ACF fields to the REST requests
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-parallactic-acf-rest.php';

		/**
		 * The class responsible to attach all ACF fields to the REST requests
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-parallactic-contact-form.php';

		/**
		 * The class responsible to attach all ACF fields to the REST requests
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-parallactic-person.php';

		new Parallactic_Meta();
		new Parallactic_Security();
		new Parallactic_Page();
		new Parallactic_ACF_REST();
		new Parallactic_Contact_Form();
		new Parallactic_Person();
		
		$this->loader = new Parallactic_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Parallactic_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Parallactic_i18n();

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

		$plugin_admin = new Parallactic_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Parallactic_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Parallactic_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
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
	 * Set php mailer config.
	 *
	 * @since     1.0.0
	 * @param     PHPMailer $mailer
	 */
	public function mailer_config(PHPMailer $mailer) {
        $mailer->IsSMTP();
        $mailer->Host = 'smtp.postmarkapp.com';
        $mailer->Port = 587;
        $mailer->SMTPAuth = true;
        $mailer->Username = '00000000-0000-0000-0000-000000000000';
        $mailer->Password = '00000000-0000-0000-0000-000000000000';
        $mailer->SMTPSecure = 'tls';
        $mailer->AuthType = 'PLAIN';
        $mailer->SMTPDebug = 0;
        $mailer->CharSet  = 'utf-8';
    }

}
