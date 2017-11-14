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
    // Posts
    add_action( 'post_updated_messages', array( $this->controller, 'build_hugo' ) );
    // add_action('post_updated', array($this, 'EventChanged'), 10, 3);
    // add_action('delete_post', array($this, 'EventDeleted'), 10, 1);
    // add_action('wp_trash_post', array($this, 'EventTrashed'), 10, 1);
    // add_action('untrash_post', array($this, 'EventUntrashed'));

    // Login/out
    // add_action('wp_login', array($this->controller, 'build_hugo'), 10, 2);
    // add_action('wp_logout', array($this->controller, 'build_hugo'));
    // add_action('shutdown', array($this->controller, 'build_hugo'));

    // Theme
		// add_action( 'switch_theme', array( $this, 'EventThemeActivated' ) );

    // Sites
    // public function HookEvents()
    // {
    //     if ($this->plugin->IsMultisite()) {
    //         add_action('admin_init', array($this, 'EventAdminInit'));
    //         if (current_user_can('switch_themes')) {
    //             add_action('shutdown', array($this, 'EventAdminShutdown'));
    //         }
    //         add_action('wpmu_new_blog', array($this, 'EventNewBlog'), 10, 1);
    //         add_action('archive_blog', array($this, 'EventArchiveBlog'));
    //         add_action('unarchive_blog', array($this, 'EventUnarchiveBlog'));
    //         add_action('activate_blog', array($this, 'EventActivateBlog'));
    //         add_action('deactivate_blog', array($this, 'EventDeactivateBlog'));
    //         add_action('delete_blog', array($this, 'EventDeleteBlog'));
    //         add_action('add_user_to_blog', array($this, 'EventUserAddedToBlog'), 10, 3);
    //         add_action('remove_user_from_blog', array($this, 'EventUserRemovedFromBlog'));
    //     }
    // }

    // Menus
    // public function HookEvents()
    // {
    //     add_action('wp_create_nav_menu', array($this, 'CreateMenu'), 10, 2);
    //     add_action('wp_delete_nav_menu', array($this, 'DeleteMenu'), 10, 1);
    //     add_action('wp_update_nav_menu', array($this, 'UpdateMenu'), 10, 2);
    //
    //     add_action('wp_update_nav_menu_item', array($this, 'UpdateMenuItem'), 10, 3);
    //     add_action('admin_menu', array($this, 'ManageMenuLocations'));
    //
    //     add_action('admin_init', array($this, 'EventAdminInit'));
    //     // Customizer trigger
    //     add_action('customize_register', array($this, 'CustomizeInit'));
    //     add_action('customize_save_after', array($this, 'CustomizeSave'));
    // }


    // Attachments
    // public function HookEvents()
    // {
    //     add_action('add_attachment', array($this, 'EventFileUploaded'));
    //     add_action('delete_attachment', array($this, 'EventFileUploadedDeleted'));
    //     add_action('admin_init', array($this, 'EventAdminInit'));
    // }

    // Content
    // public function HookEvents()
    // {
    // 	if (current_user_can("edit_posts")) {
    // 		add_action('admin_init', array($this, 'EventWordpressInit'));
    // 	}
    // 	add_action('transition_post_status', array($this, 'EventPostChanged'), 10, 3);
    // 	add_action('delete_post', array($this, 'EventPostDeleted'), 10, 1);
    // 	add_action('wp_trash_post', array($this, 'EventPostTrashed'), 10, 1);
    // 	add_action('untrash_post', array($this, 'EventPostUntrashed'));
    // 	add_action('edit_category', array($this, 'EventChangedCategoryParent'));
    // 	add_action('save_post', array($this, 'SetRevisionLink'), 10, 3);
    // 	add_action('publish_future_post', array($this, 'EventPublishFuture'), 10, 1);
    //
    // 	add_action('create_category', array($this, 'EventCategoryCreation'), 10, 1);
    // 	add_action( 'create_post_tag', array( $this, 'EventTagCreation' ), 10, 1 );
    //
    // 	add_action( 'wp_head', array( $this, 'ViewingPost' ), 10 );
    // 	add_filter('post_edit_form_tag', array($this, 'EditingPost'), 10, 1);
    //
    // 	add_filter( 'wp_update_term_data', array( $this, 'event_terms_rename' ), 10, 4 );
    // }


    // Comments
    // public function HookEvents()
    // {
    //     add_action('edit_comment', array($this, 'EventCommentEdit'), 10, 1);
    //     add_action('transition_comment_status', array($this, 'EventCommentApprove'), 10, 3);
    //     add_action('spammed_comment', array($this, 'EventCommentSpam'), 10, 1);
    //     add_action('unspammed_comment', array($this, 'EventCommentUnspam'), 10, 1);
    //     add_action('trashed_comment', array($this, 'EventCommentTrash'), 10, 1);
    //     add_action('untrashed_comment', array($this, 'EventCommentUntrash'), 10, 1);
    //     add_action('deleted_comment', array($this, 'EventCommentDeleted'), 10, 1);
    //     add_action('comment_post', array($this, 'EventComment'), 10, 2);
    // }

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
