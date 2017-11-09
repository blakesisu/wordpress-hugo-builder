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

// If the functions have already been autoloaded, don't reload.
// This fixes function duplication during unit testing.
// $path = dirname( __FILE__ ) . '/vendor/autoload_52.php';
// if ( ! function_exists( 'get_the_github_view_link' ) && file_exists( $path ) ) {
// 	require_once $path;
// }

include 'lib/controller.php';
include 'logger.php';
// include 'lib/admin.php';

add_action( 'plugins_loaded', array( new WordPress_Hugo_Builder, 'boot' ) );

/**
 * Class WordPress_Hugo_Builder
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
  public static $version = '0.1';

  /**
   * Controller object.
   *
   * @var WordPress_Hugo_Builder_Controller
   */
  public $controller;

  /**
   * Logger object.
   *
   * @var Logger
   */
  public $logger;

  /**
   * Admin object.
   *
   * @var WordPress_Hugo_Builder_Admin
   */
  // public $admin;

  /**
   * CLI object.
   *
   * @var WordPress_Hugo_Builder_CLI
   */
  // protected $cli;

  /**
   * Request object.
   *
   * @var WordPress_Hugo_Builder_Request
   */
  // protected $request;

  /**
   * Response object.
   *
   * @var WordPress_Hugo_Builder_Response
   */
  // protected $response;

  /**
   * Api object.
   *
   * @var WordPress_Hugo_Builder_Api
   */
  // protected $api;

  /**
   * Export object.
   *
   * @var WordPress_Hugo_Builder_Export
   */
  // protected $export;

  /**
   * Semaphore object.
   *
   * @var WordPress_Hugo_Builder_Semaphore
   */
  // protected $semaphore;

  /**
   * Called at load time, hooks into WP core
   */
  public function __construct() {
    self::$instance = $this;

    // if ( is_admin() ) {
    //   $this->admin = new WordPress_Hugo_Builder_Admin;
    // }

    $this->controller = new WordPress_Hugo_Builder_Controller( $this );

    // if ( defined( 'WP_CLI' ) && WP_CLI ) {
    //   WP_CLI::add_command( 'wphb', $this->cli() );
    // }
  }

  /**
   * Attaches the plugin's hooks into WordPress.
   */
  public function boot() {
    // register_activation_hook( __FILE__, array( $this, 'activate' ) );
    // add_action( 'admin_notices', array( $this, 'activation_notice' ) );

    // Controller actions.
    // At least triggers when posts are created and updated
    add_action( 'post_updated_messages', array( $this->controller, 'build_hugo' ) );
    // add_action( 'publish_post', array( $this->controller, 'export_post' ) );
    // add_action( 'delete_post', array( $this->controller, 'export_post' ) );

    // add_shortcode( 'wphb', 'write_wphb_link' );

    // do_action( 'wphb_boot', $this );
  }

  /**
   * Enables the admin notice on initial activation
   */
  // public function activate() {
  //   if ( 'yes' !== get_option( '_wpghs_fully_exported' ) ) {
  //     set_transient( '_wphb_activated', 'yes' );
  //   }
  // }

  /**
   * Displays the activation admin notice
   */
  // public function activation_notice() {
  //   if ( ! get_transient( '_wphb_activated' ) ) {
  //     return;
  //   }
  //
  //   delete_transient( '_wphb_activated' );
  //
  // }

  /**
   * Get the Controller object.
   *
   * @return WordPress_Hugo_Builder_Controller
   */
  public function controller() {
    return $this->controller;
  }

  /**
   * Lazy-load the CLI object.
   *
   * @return WordPress_Hugo_Builder_CLI
   */
  // public function cli() {
  // 	if ( ! $this->cli ) {
  // 		$this->cli = new WordPress_Hugo_Builder_CLI;
  // 	}
  //
  // 	return $this->cli;
  // }

  /**
   * Lazy-load the Request object.
   *
   * @return WordPress_Hugo_Builder_Request
   */
  // public function request() {
  //   if ( ! $this->request ) {
  //     $this->request = new WordPress_Hugo_Builder_Request( $this );
  //   }
  //
  //   return $this->request;
  // }

  /**
   * Lazy-load the Response object.
   *
   * @return WordPress_Hugo_Builder_Response
   */
  // public function response() {
  //   if ( ! $this->response ) {
  //     $this->response = new WordPress_Hugo_Builder_Response( $this );
  //   }
  //
  //   return $this->response;
  // }

  /**
   * Lazy-load the Api object.
   *
   * @return WordPress_Hugo_Builder_Api
   */
  // public function api() {
  //   if ( ! $this->api ) {
  //     $this->api = new WordPress_Hugo_Builder_Api( $this );
  //   }
  //
  //   return $this->api;
  // }

  /**
   * Lazy-load the Export object.
   *
   * @return WordPress_Hugo_Builder_Export
   */
  // public function export() {
  // 	if ( ! $this->export ) {
  // 		$this->export = new WordPress_Hugo_Builder_Export( $this );
  // 	}
  //
  // 	return $this->export;
  // }

  /**
   * Lazy-load the Semaphore object.
   *
   * @return WordPress_Hugo_Builder_Semaphore
   */
  // public function semaphore() {
  // 	if ( ! $this->semaphore ) {
  // 		$this->semaphore = new WordPress_Hugo_Builder_Semaphore;
  // 	}
  //
  // 	return $this->semaphore;
  // }

  /**
   * Print to WP_CLI if in CLI environment or
   * write to debug.log if WP_DEBUG is enabled
   *
   * @source http://www.stumiller.me/sending-output-to-the-wordpress-debug-log/
   *
   * @param mixed  $msg   Message text.
   * @param string $write How to write the message, if CLI.
   */
  public static function write_log( $msg, $write = 'line' ) {
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
      if ( is_array( $msg ) || is_object( $msg ) ) {
        WP_CLI::print_value( $msg );
      } else {
        WP_CLI::$write( $msg );
      }
    } elseif ( true === WP_DEBUG ) {
      if ( is_array( $msg ) || is_object( $msg ) ) {
        error_log( print_r( $msg, true ) );
      } else {
        error_log( $msg );
      }
    }
  }
}
?>
