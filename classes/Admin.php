<?php
/**
 * Admin object manages settings and administration
 * @package WordPress_Hugo_Builder
 */

/**
 * Class WPHB_Admin
 */
class WPHB_Admin {

  /**
   * Application container.
   *
   * @var WordPress_Hugo_Builder
   */
  public $app;

  /**
   * Instantiates a new Admin object
   *
   * @param WordPress_Hugo_Builder $app Application container.
   */
  public function __construct( WordPress_Hugo_Builder $app ) {
    $this->app = $app;
    $this->setup_admin_actions();
  }

  public function setup_admin_actions(){
    add_action('admin_init', array($this, 'hugo_endpoint_setting'));
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
