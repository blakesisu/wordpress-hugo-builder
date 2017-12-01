<?php
/**
 * Admin object manages settings and administration
 * @package WordPress_Hugopress
 */

/**
 * Class WPHB_Admin
 */
class WPHB_Admin {

  /**
   * Application container.
   *
   * @var WordPress_Hugopress
   */
  public $app;

  /**
   * Instantiates a new Admin object
   *
   * @param WordPress_Hugopress $app Application container.
   */
  public function __construct( WordPress_Hugopress $app ) {
    $this->app = $app;
    $this->setup_admin_actions();
  }

  public function setup_admin_actions(){
    add_action('admin_init', array($this, 'hugo_endpoint_setting'));
    // add_action('admin_menu', array($this, 'create_hugopress_options_page'));
  }

  // public function create_hugopress_options_page(){
  //     // Add the menu item and page
  //     $page_title = 'HugoPress Settings Page';
  //     $menu_title = 'HugoPress Plugin';
  //     $capability = 'manage_options';
  //     $slug = 'wp-hugopress';
  //     $callback = array( $this, 'plugin_settings_page_content' );
  //     $icon = 'dashicons-admin-plugins';
  //     $position = 100;
  //
  //     add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
  }
  public function hugo_endpoint_setting(){

      add_settings_section(
          'hugopress-rest-section',
          'HugoPress Settings',
          array($this, 'display_hugoPress_settings_section'),
          'general'
      );
      add_settings_field(
          'hugopress-rest-input',
          'HugoPress REST endpoint',
          array($this, 'display_hugoPress_url_input'),
          'general',
          'hugopress-rest-section',
          array( 'label_for' => 'hugopress-rest-input' )
      );
      register_setting(
          'general',
          'hugopress-rest-input'
      );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function sanitize($input){
      $newinput = array();
      // $newinput['text_string'] = $input['text_string'];
      $newinput['text_string'] = $input['text_string'] ? 'yah' : 'nah';
      return $newinput;
  }

  public function display_hugoPress_settings_section($args){
      echo '<p>HugoPress section header</p>';
  }

  public function display_hugoPress_url_input($args){
      echo '<input type="text" id="'.$args["label_for"].'" name="'.$args['label_for'].'" value="'.get_option($args["label_for"]).'"/> REST input instructions';
  }
}
