<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Menus sensor.
 *
 * 2078 User created new menu
 * 2079 User added content to a menu
 * 2080 User removed content from a menu
 * 2081 User deleted menu
 * 2082 User changed menu setting
 * 2083 User modified content in a menu
 * 2084 User changed name of a menu
 * 2085 User changed order of the objects in a menu
 * 2089 User moved objects as a sub-item
 */
// Attachments
class WPHB_Sensors_Menus extends WPHB_AbstractSensor {
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
    add_action('wp_create_nav_menu', array($this->app->compiler, 'test_hugo'));
    add_action('wp_delete_nav_menu', array($this->app->compiler, 'test_hugo'));
    add_action('wp_update_nav_menu', array($this->app->compiler, 'test_hugo'));

    add_action('wp_update_nav_menu_item', array($this->app->compiler, 'test_hugo'));
    add_action('admin_menu', array($this->app->compiler, 'test_hugo'));
    add_action('admin_init', array($this->app->compiler, 'test_hugo'));
    // Customizer trigger
    add_action('customize_register', array($this->app->compiler, 'test_hugo'));
    add_action('customize_save_after', array($this->app->compiler, 'test_hugo'));
  }

}
