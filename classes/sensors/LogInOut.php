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
   * @var WordPress_Hugopress
   */
  public $app;
  // protected $app;

  public function __construct(WordPress_Hugopress $app) {
      $this->app = $app;
  }

  /**
   * Listening to events using WP hooks.
   */
  public function HookEvents() {
    $this->addHooks(
      array (
        'wp_login',
        'wp_logout',
      )
    );
  }
}
