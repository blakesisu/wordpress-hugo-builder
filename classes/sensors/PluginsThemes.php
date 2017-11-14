<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Plugins & Themes sensor.
 *
 * 5000 User installed a plugin
 * 5001 User activated a WordPress plugin
 * 5002 User deactivated a WordPress plugin
 * 5003 User uninstalled a plugin
 * 5004 User upgraded a plugin
 * 5005 User installed a theme
 * 5006 User activated a theme
 * 5007 User uninstalled a theme
 * 5019 A plugin created a post
 * 5020 A plugin created a page
 * 5021 A plugin created a custom post
 * 5025 A plugin deleted a post
 * 5026 A plugin deleted a page
 * 5027 A plugin deleted a custom post
 * 5031 User updated a theme
 * 2106 A plugin modified a post
 * 2107 A plugin modified a page
 * 2108 A plugin modified a custom post
 */
class WPHB_Sensors_PluginsThemes extends WPHB_AbstractSensor {
  /**
   * @var WordPress_Hugo_Builder
   */
  public $app;
  // protected $app;

  public function __construct(WordPress_Hugo_Builder $app) {
    $this->app = $app;
  }

  /**
   * Listening to events using WP hooks.
   */
  public function HookEvents() {
    $has_permission = ( current_user_can( 'install_plugins' ) || current_user_can( 'activate_plugins' ) ||
              current_user_can( 'delete_plugins' ) || current_user_can( 'update_plugins' ) || current_user_can( 'install_themes' ) );

    add_action( 'admin_init', array($this->app->compiler, 'test_hugo'));
    if ( $has_permission ) {
      add_action( 'shutdown', array($this->app->compiler, 'test_hugo'));
    }
    add_action( 'switch_theme', array($this->app->compiler, 'test_hugo'));

    // TO DO.
    add_action( 'wp_insert_post', array($this->app->compiler, 'test_hugo'));
    add_action( 'delete_post', array($this->app->compiler, 'test_hugo'));
  }

}
