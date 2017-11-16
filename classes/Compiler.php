<?php
/**
 * Compiler object manages tree retrieval, manipulation and publishing
 * @package WordPress_Hugo_Builder
 */

/**
 * Class WPHB_Compiler
 */
class WPHB_Compiler {

  /**
   * Application container.
   *
   * @var WordPress_Hugo_Builder
   */
  public $app;

  /**
   * Instantiates a new Compiler object
   *
   * @param WordPress_Hugo_Builder $app Application container.
   */
  public function __construct( WordPress_Hugo_Builder $app ) {
    $this->app = $app;
    add_action( 'admin_head', array($this, 'hugo_css') );
  }

  public function mock_hugo() {
    $this->mockHugoNotif();
  }

  public function mockHugoNotif() {
    $action = $this->app->action;
    $content = $this->get_lyric();

    // $hugo = SITE_ROOT."/wp-content/plugins/wordpress-hugo-builder/hugo_log.txt";
    // $this->estLogger($hugo);
    // $this->logger->putLog($content);

    echo "<p id='hugo'>$content $action</p>";
  }

  public function estLogger ($location) {
    $this->logger = new Logger($location);
    $this->logger->setTimestamp("D M d 'y h.i A");
  }

  // Actually hit end point
  public function postHugoAPI($instructions) {
    $url = 'http://localhost:3000/wp-hugo';
    // $payload = json_encode ($instructions);

    $response = wp_remote_post(
      $url,
      array('body' => array(
          'payload' => json_encode ($instructions)
        )
      )
    );
    // $response = wp_remote_get( $url );

    if ( is_wp_error( $response ) ) {
        $frontRes = $response->get_error_message();
    } else {
        $frontRes = $response['body'];
    }

    $this->logger->putLog($frontRes);
    echo "<p id='hugo'>$frontRes</p>";
  }

  /**
   * Passes commands to hugo build process on whatever instance it's running on.
   *
   * Called on multitude of hooks.
   *
   * @param int $post_id Post ID.
   *
   * @return boolean
   */
  public function instructHugo() {
    // $chosen = $this->get_lyric();
    // $action = $this->app->action;
    $hugo = SITE_ROOT."/wp-content/plugins/wordpress-hugo-builder/hugo_log.txt";
    $this->estLogger($hugo);

    $this->postHugoAPI($this->parseAction($this->app->action));
  }

  // Determine what kind of build command to pass API
  public function parseAction($action) {
    $command = $action === 'post_updated_messages' ? 'build-page' : 'build-generic';
    return array(
      'text' => $command,
      'action' => $action,
    );
  }

  // Test notification
  /*
  public function postSlackNotif($content) {
    $url = 'https://hooks.slack.com/services/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';

    $payload = json_encode (
      array(
        'text' => $content
      )
    );

    $response = wp_remote_post(
      $url,
      array('body' => $payload)
    );


    if ( is_wp_error( $response ) ) {
        $frontRes = $response->get_error_message();
    } else {
        $frontRes = $response['body'];
    }

    $this->logger->putLog($frontRes);
    echo "<p id='hugo'>$frontRes</p>";
  }
   */

  public function get_lyric() {
    /** These are the lyrics to Hello Dolly */
    $lyrics = "Hello, Dolly
      Well, hello, Dolly
      It's so nice to have you back where you belong
      You're lookin' swell, Dolly
      I can tell, Dolly
      You're still glowin', you're still crowin'
      You're still goin' strong
      We feel the room swayin'
      While the band's playin'
      One of your old favourite songs from way back when
      So, take her wrap, fellas
      Find her an empty lap, fellas
      Dolly'll never go away again
      Hello, Dolly
      Well, hello, Dolly
      It's so nice to have you back where you belong
      You're lookin' swell, Dolly
      I can tell, Dolly
      You're still glowin', you're still crowin'
      You're still goin' strong
      We feel the room swayin'
      While the band's playin'
      One of your old favourite songs from way back when
      Golly, gee, fellas
      Find her a vacant knee, fellas
      Dolly'll never go away
      Dolly'll never go away
      Dolly'll never go away again";

    // Here we split it into lines
    $lyrics = explode( "\n", $lyrics );

    // And then randomly choose a line
    return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
  }


  // We need some CSS to position the paragraph
  public function hugo_css() {
    // This makes sure that the positioning is also good for right-to-left languages
    $x = is_rtl() ? 'left' : 'right';

    echo "
    <style type='text/css'>
    #hugo {
      float: $x;
      padding-$x: 15px;
      padding-top: 5px;		
      margin: 0;
      font-size: 11px;
    }
    </style>
    ";
  }
}
