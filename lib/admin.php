<?php
/**
 * Administrative UI views and callbacks
 * @package WordPress_Hugo_Builder
 */

/**
 * Class WordPress_Hugo_Builder_Admin
 */
class WordPress_Hugo_Builder_Admin {

  /**
   * Hook into GitHub API
   */
  public function __construct() {
    add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    // add_action( 'admin_init', array( $this, 'register_settings' ) );
    // add_action( 'current_screen', array( $this, 'trigger_cron' ) );
  }

}
