<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Wordpress Posts.
 *
 */
// Attachments
class WPHB_Sensors_Posts extends WPHB_AbstractSensor {
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
    // $this->addHooks(
    //   array (
    //   )
    // );
  }
}
