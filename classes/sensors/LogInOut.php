<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Login/Logout sensor.
 *
 * 1000 User logged in
 * 1001 User logged out
 * 1002 Login failed
 * 1003 Login failed / non existing user
 * 1004 Login blocked
 * 4003 User has changed his or her password
 */
// Attachments
class WPHB_Sensors_LogInOut extends WPHB_AbstractSensor {
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
    add_action('wp_login', array($this->app->compiler, 'test_hugo'));
    add_action('wp_logout', array($this->app->compiler, 'test_hugo'));
    add_action('password_reset', array($this->app->compiler, 'test_hugo'));
    add_action('wp_login_failed', array($this->app->compiler, 'test_hugo'));
    add_action('clear_auth_cookie', array($this->app->compiler, 'test_hugo'));
  }

}
