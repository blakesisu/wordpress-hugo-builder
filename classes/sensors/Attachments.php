<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Wordpress Attachments.
 *
 * 2010 User uploaded file from Uploads directory
 * 2011 User deleted file from Uploads directory
 * 2046 User changed a file using the theme editor
 * 2051 User changed a file using the plugin editor
 */
// Attachments
class WPHB_Sensors_Attachments extends WPHB_AbstractSensor {
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
    add_action('add_attachment', array($this->app->compiler, 'test_hugo'));
    add_action('delete_attachment', array($this->app->compiler, 'test_hugo'));
    add_action('admin_init', array($this->app->compiler, 'test_hugo'));
  }

}
