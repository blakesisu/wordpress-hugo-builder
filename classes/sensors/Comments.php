<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Wordpress Comments.
 *
 * 2090 User approved a comment
 * 2091 User unapproved a comment
 * 2092 User replied to a comment
 * 2093 User edited a comment
 * 2094 User marked a comment as Spam
 * 2095 User marked a comment as Not Spam
 * 2096 User moved a comment to trash
 * 2097 User restored a comment from the trash
 * 2098 User permanently deleted a comment
 * 2099 User posted a comment
 */
// Attachments
class WPHB_Sensors_Comments extends WPHB_AbstractSensor {
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
    add_action('edit_comment', array($this->app->compiler, 'test_hugo'));
    add_action('transition_comment_status', array($this->app->compiler, 'test_hugo'));
    add_action('spammed_comment', array($this->app->compiler, 'test_hugo'));
    add_action('unspammed_comment', array($this->app->compiler, 'test_hugo'));
    add_action('trashed_comment', array($this->app->compiler, 'test_hugo'));
    add_action('untrashed_comment', array($this->app->compiler, 'test_hugo'));
    add_action('deleted_comment', array($this->app->compiler, 'test_hugo'));
    add_action('comment_post', array($this->app->compiler, 'test_hugo'));
  }

}