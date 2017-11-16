<?php
/**
 * @package WPHB
 * @subpackage Sensors
 * Site sensor.
 *
 * 4010 Existing user added to a site
 * 4011 User removed from site
 * 4012 New network user created
 * 7000 New site added on the network
 * 7001 Existing site archived
 * 7002 Archived site has been unarchived
 * 7003 Deactivated site has been activated
 * 7004 Site has been deactivated
 * 7005 Existing site deleted from network
 * 5008 Activated theme on network
 * 5009 Deactivated theme from network
 */
// Attachments
class WPHB_Sensors_Sites extends WPHB_AbstractSensor {
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
    $this->addHooks(
      array (
        'wpmu_new_blog',
        'archive_blog',
        'unarchive_blog',
        'activate_blog',
        'deactivate_blog',
        'delete_blog',
        'add_user_to_blog',
        'remove_user_from_blog'
      )
    );
  }
}
