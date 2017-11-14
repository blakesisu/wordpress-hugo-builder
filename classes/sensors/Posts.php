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
    add_action( 'post_updated_messages', array( $this->app->compiler, 'build_hugo' ) );
    // add_action('post_updated', array($this, 'EventChanged'), 10, 3);
    // add_action('delete_post', array($this, 'EventDeleted'), 10, 1);
    // add_action('wp_trash_post', array($this, 'EventTrashed'), 10, 1);
    // add_action('untrash_post', array($this, 'EventUntrashed'));
  }

}
