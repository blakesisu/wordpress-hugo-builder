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
    $this->add_defaults_option();
  }

  // TODO: allow actions to be hooked
  public function setup_admin_actions(){
    // add_action('admin_menu', array($this, 'create_hugopress_options_page'));
    // add_action('admin_init', array($this, 'create_hugopress_options'));
    add_action('admin_menu', array($this, 'create_pressword_options_page'));
    add_action('admin_init', array($this, 'create_pressword_options'));
  }

  public function self_consuming_actions(){
      // api test
      add_action( 'wp_ajax_nopriv_test_hugopress_api', array($this, 'test_hugopress_api') );
      add_action( 'wp_ajax_test_hugopress_api', array($this, 'test_hugopress_api') );

      // api addition
      add_action( 'wp_ajax_nopriv_set_new_api', array($this, 'set_new_api') );
      add_action( 'wp_ajax_set_new_api', array($this, 'set_new_api') );
  }

  public function add_defaults_option() {
    $tmp = get_option('pressword');
    if(!is_array($tmp)) {
      $apis = array(
        'apis' => array(
          'hugo' => 'http://listener:3000/hugopress'
        )
      );
      update_option('pressword', $apis);
    }
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


  public function set_new_api(){

    var_dump($_POST);
    $alias = $_POST['alias'];
    $url = $_POST['url'];

    if( $alias == '' || $url = '' ) {
      die(
        json_encode(
          array(
            'success' => false,
            'message' => 'Missing required information.'
          )
        )
      );
    }

    // $options = get_option('pressword');
    // update_option( $options['apis'][$alias], $url );

    die(
      json_encode(
        array(
          'success' => true,
          'message' => 'Database updated successfully.'
        )
      )
    );
  }

  public function create_pressword_options_page(){
      // Add the menu item and page
      $page_title = 'PressWord Settings Page';
      $menu_title = 'PressWord Plugin';
      $capability = 'manage_options';
      $slug = 'wp-hugopress';
      $callback = array( $this, 'pressword_settings_page_content' );
      $icon = 'dashicons-admin-plugins';
      $position = 100;

      // add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );

      // these two do the same
      // add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $slug, $callback);
      add_options_page($page_title, $menu_title, $capability, $slug, $callback);
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

      // add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
      add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $slug, $callback);
  }


  public function hugopress_settings_page_content(){ ?>
     <div class="wrap">
        <h2>HugoPress Settings</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'wp-hugopress' );
                do_settings_sections( 'wp-hugopress' );
                submit_button();
            ?>
        </form>
     </div> <?php
  }

  public function pressword_settings_page_content(){
    // if( $_POST['updated'] === 'true' ){
    //   $this->handle_form();
    // }
    ?>
     <div class="wrap">
        <h2>PressWord Settings</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'pressword' );
                do_settings_sections( 'pressword' );
                submit_button();
            ?>
        </form>
     </div> <?php
  }

  // this should trigger on add
  public function create_pressword_options(){
      // $this->pressword_begin_api();
      $this->pressword_endpoint_setting();
      $this->pressword_display_setting();
  }

  public function create_hugopress_options(){
      $this->hugopress_endpoint_setting();
      $this->hugopress_api_test();
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

  // public function pressword_begin_api(){
  //     add_settings_field(
  //         'pressword-add-api',
  //         'PressWord add API name',
  //         array($this, 'begin_pressword_api'),
  //         'wp-hugopress',
  //         'pressword-api-section',
  //         array( 'label_for' => 'pressword-add-api' )
  //     );
  //     register_setting(
  //         'wp-hugopress',
  //         'pressword-add-api'
  //     );
  // }

  public function pressword_endpoint_setting(){
      add_settings_section(
          'pressword-new-api',
          'Add an API',
          array($this, 'display_pressword_settings_section'),
          'pressword'
      );
      // add_settings_field(
      //     'pressword-add-api',
      //     'PressWord add API name',
      //     array($this, 'begin_pressword_api'),
      //     'wp-hugopress',
      //     'pressword-api-section',
      //     array( 'label_for' => 'pressword-add-api' )
      // );
      // register_setting(
      //     'wp-hugopress',
      //     'pressword-add-api'
      // );
      add_settings_field(
          'pressword-api-input',
          'Add a PressWord API endpoint',
          array($this, 'display_pressword_url_input'),
          'pressword',
          'pressword-new-api',
          array( 'label_for' => 'pressword' )
      );
      register_setting(
          'pressword',
          'pressword'
      );
  }


  public function pressword_display_setting(){
    add_settings_section( 'apis_display', 'APIs', array( $this, 'pressword_display_apis' ), 'pressword' );
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



  // pressword logic
  public function display_pressword_settings_section($args){
      // $options = get_option('pressword');
      // $foo = $options['apis']['hugo'];
      // echo "$foo";
      echo '<p>Configure a URL Alias and Endpoint</p>';
  }

  public function display_pressword_url_input($args){
      $label = $args["label_for"];
      echo '
      <div id="'.$label.'-alias-container" class="form-inline">
        <input id="'.$label.'-alias-input" value="" class="form-inline" type="text" style="display: inline;"></input> &nbsp; Add API name
      </div>
      <div id="'.$label.'-url-container" class="form-inline">
        <input type="text" id="'.$label.'-url-input" value=""/> &nbsp; Enter API url for PressWord broadcasting
      </div>
      </br>
      <button id="'.$label.'-api-submit" class="btn" style="display: inline-block;">Add API</button>';
  }

  public function pressword_display_apis(){
    $options = get_option('pressword');
    $apis = $options['apis'];
    $api_count = 1;
    foreach($apis as $api => $endpoint ) {
      echo '
        <div class="api-display">
          <p>'.$api_count.'. &nbsp; API alias: "'.$api.'", &nbsp; API endpoint: "'.$endpoint.'"</p>
        </div>';
      $api_count = $api_count + 1;
    }
  }

  public function checkHugoAPI($url) {
      return wp_remote_get( $url );
  }
}
