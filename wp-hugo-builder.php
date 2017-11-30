<?php
/**
 * @package WordPress_Hugo_Builder
 * @version 0.1
 */
/*
Plugin Name: WordPress Hugo Builder
Plugin URI: http://wordpress.org/plugins/wp-hugo-builder/
Description: This is not just a plugin, it's the plugin.
Authors: Blake Watkins, Steven Waller
Version: 1.6
Author URI: https://blkmwtkns.co/
*/

/**
 * @package WPHB
 *
 * Main application class for the plugin. Responsible for bootstrapping
 * any hooks and instantiating all service classes.
 */
class WordPress_Hugo_Builder {

  /**
   * Object instance.
   *
   * @var self
   */
  public static $instance;

  /**
   * Language text domain.
   *
   * @var string
   */
  public static $text_domain = 'wp-hugo-builder';

  /**
   * Current version.
   *
   * @var string
   */
  public $version = '0.1';
	const PLG_CLS_PRFX = 'WPHB_';

  /**
   * Compiler object.
   *
   * @var WPHB_Compiler
   */
  public $compiler;

  /**
   * Logger object.
   *
   * @var Logger
   */
  public $logger;

  /**
   * Sensor object.
   *
   * @var Sensors
   */
  public $sensors;

  /**
   * current wp action.
   *
   * @var action
   */
  public $action = 'nope';

	/**
	 * Standard singleton pattern.
	 * WARNING! To ensure the system always works as expected, AVOID using this method.
	 * Instead, make use of the plugin instance provided by 'wsal_init' action.
	 * @return WordPress_Hugo_Builder Returns the current plugin instance.
	 */
	public static function GetInstance()
	{
		static $instance = null;
		if (!$instance) {
			$instance = new self();
		}
		return $instance;
	}

  /**
   * Called at load time, hooks into WP core
   */
  public function __construct() {
    // Define important plugin constants.
    $this->define_constants();

    require_once( 'classes/Autoloader.php' );
    require_once( 'logger.php' );
    $this->autoloader = new WPHB_Autoloader( $this );
    $this->autoloader->Register( self::PLG_CLS_PRFX, $this->GetBaseDir() . 'classes' . DIRECTORY_SEPARATOR );

    $this->compiler = new WPHB_Compiler( $this );
    $this->sensors = new WPHB_SensorManager( $this );

    add_action( 'init', array( $this, 'Init' ) );
  }

  /**
   * Boot/Loader method
   */
  public function boot() {
    // Load up stuff here if needed
  }


  /**
   * @internal Start to trigger the events after installation.
   */
  public function Init() {
    // Start listening to events
    WordPress_Hugo_Builder::GetInstance()->sensors->HookEvents();
  }

  /**
   * Returns the class name of a particular file that contains the class.
   * @param string $file File name.
   * @return string Class name.
   */
  public function GetClassFileClassName($file)
  {
    return $this->autoloader->GetClassFileClassName($file);
  }

  public function GetBaseUrl()
  {
    return plugins_url('', __FILE__);
  }

  /**
   * @return string Full path to plugin directory WITH final slash.
   */
  public function GetBaseDir()
  {
    return plugin_dir_path(__FILE__);
  }

  /**
   * @return string Plugin directory name.
   */
  public function GetBaseName()
  {
    return plugin_basename(__FILE__);
  }

  public function define_constants() {

    // Plugin version.
    if ( ! defined( 'WPHB_VERSION' ) ) {
      define( 'WPHB_VERSION', $this->version );
    }
    // Plugin Name.
    if ( ! defined( 'WPHB_BASE_NAME' ) ) {
      define( 'WPHB_BASE_NAME', plugin_basename( __FILE__ ) );
    }
    // Plugin Directory URL.
    if ( ! defined( 'WPHB_BASE_URL' ) ) {
      define( 'WPHB_BASE_URL', plugin_dir_url( __FILE__ ) );
    }
    // Plugin Directory Path.
    if ( ! defined( 'WPHB_BASE_DIR' ) ) {
      define( 'WPHB_BASE_DIR', plugin_dir_path( __FILE__ ) );
    }
    // TODO: this needs to be abstracted, path to specific
    // Plugin Logging Path.
    // if ( ! defined( 'WPHB_LOGGER' ) ) {
      // define( 'WPHB_BASE_DIR', "/wp-content/plugins/wordpress-hugo-builder/hugo_log.txt" );
    // }
  }

}

// add_action('plugins_loaded', array(WordPress_Hugo_Builder::GetInstance(), 'boot'));

return WordPress_Hugo_Builder::GetInstance();
