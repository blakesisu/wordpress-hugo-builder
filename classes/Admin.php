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
    $this->self_consuming_actions();
  }

  // TODO: allow actions to be hooked
  public function setup_admin_actions(){
    add_action('admin_menu', array($this, 'create_hugopress_options_page'));
    add_action('admin_init', array($this, 'create_hugopress_options'));
  }

  public function self_consuming_actions(){
      add_action( 'wp_ajax_nopriv_test_hugopress_api', array($this, 'test_hugopress_api') );
      add_action( 'wp_ajax_test_hugopress_api', array($this, 'test_hugopress_api') );
  }

  public function test_hugopress_api(){
      if(isset($_POST['input'])){
          switch ($_POST['input']) {
              case '/':
                  $endpoint = '';
                  break;
              default:
                  $endpoint = $_POST['input'];
                  break;
          }

          $response = $this->checkHugoAPI(get_option('hugopress-rest-input').$endpoint);

          if (isset($response)) {

              $response = json_decode($response['body'], true);
              echo $response["routes"];
          } else {
              echo 'No response';
          }

      } else {
          echo 'Bad input';
      }
      die();
  }

  public function create_hugopress_options_page(){
      // Add the menu item and page
      $page_title = 'HugoPress Settings Page';
      $menu_title = 'HugoPress Plugin';
      $capability = 'manage_options';
      $slug = 'wp-hugopress';
      $callback = array( $this, 'hugopress_settings_page_content' );
      $icon = 'dashicons-admin-plugins';
      $position = 100;

      add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
  }

  public function hugopress_settings_page_content(){ ?>
     <div class="wrap">
        <h2>HugoPress Settings Page</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'wp-hugopress' );
                do_settings_sections( 'wp-hugopress' );
                submit_button();
            ?>
        </form>
     </div> <?php
  }


  public function create_hugopress_options(){
      $this->hugopress_endpoint_setting();
      $this->hugopress_api_test();
  }


  public function hugopress_api_test(){
      add_settings_field(
          'hugopress-api-test',
          'HugoPress REST API test',
          array($this, 'display_hugopress_api_test'),
          'wp-hugopress',
          'hugopress-rest-section',
          array( 'label_for' => 'hugopress-api-test' )
      );
      register_setting(
          'wp-hugopress',
          'hugopress-api-test'
      );
  }

  public function hugopress_endpoint_setting(){
      add_settings_section(
          'hugopress-rest-section',
          'HugoPress REST API Settings',
          array($this, 'display_hugopress_settings_section'),
          'wp-hugopress'
      );
      add_settings_field(
          'hugopress-rest-input',
          'HugoPress REST endpoint',
          array($this, 'display_hugopress_url_input'),
          'wp-hugopress',
          'hugopress-rest-section',
          array( 'label_for' => 'hugopress-rest-input' )
      );
      register_setting(
          'wp-hugopress',
          'hugopress-rest-input'
      );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  // public function sanitize($input){
  //     $newinput = array();
  //     // $newinput['text_string'] = $input['text_string'];
  //     $newinput['text_string'] = $input['text_string'] ? 'yah' : 'nah';
  //     return $newinput;
  // }

  public function display_hugopress_settings_section($args){
      echo '<p>Configure HugoPress REST API specific settings</p>';
  }

  public function display_hugopress_url_input($args){
      $label = $args["label_for"];
      echo '<input type="text" id="'.$label.'" name="'.$label.'" value="'.get_option($label).'"/> HugoPress REST API base url';
  }

  public function display_hugopress_api_test($args){
      $label = $args["label_for"];
echo '<div id="'.$label.'-form" class="form-inline">
        <input id="'.$label.'-input" class="form-inline" type="text" style="display: inline;" disabled></input>
        <button id="'.$label.'-submit" class="btn" style="display: inline-block;">Submit</button>
    </div>
        <div id ="hugopress-api-test-mssg" style="display: block;"></div>';
  }

  public function checkHugoAPI($url) {
      return wp_remote_get( $url );
  }
}
