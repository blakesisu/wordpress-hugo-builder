<?php
/**
 * Compiler object manages tree retrieval, manipulation and publishing
 * @package WordPress_Hugopress
 */

/**
 * Class WPHB_Compiler
 */
class WPHB_Compiler {

    /**
     * Application container.
     *
     * @var WordPress_Hugopress
     */
    public $app;

    /**
     * Instantiates a new Compiler object
     *
     * @param WordPress_Hugopress $app Application container.
     */
    public function __construct(WordPress_Hugopress $app)
    {
        $this->app = $app;
        add_action('admin_head', array($this, 'hugo_css'));
    }

    // This function used to do more...
    public function mock_hugo()
    {
        $this->mockHugoNotif();
    }

    public function mockHugoNotif()
    {
        $action = $this->app->action;
        $content = $this->get_lyric();

        // $hugo = SITE_ROOT."/wp-content/plugins/wordpress-hugopress/hugo_log.txt";
        // $this->estLogger($hugo);
        // $this->logger->putLog($content);

        echo "<p id='hugo'>$content $action</p>";
    }

    public function estLogger($location)
    {
        $this->logger = new Logger($location);
        $this->logger->setTimestamp("D M d 'y h.i A");
    }

    // Check Hugo API status
    public function checkHugoAPIStatus($url)
    {
        return wp_remote_get($url);
    }

    // Actually hit end point
    // TODO: url input
    public function postHugoAPI($instructions, $url)
    {
        // localhost test
        // $url = 'http://localhost:3000/wp-hugo';

        // localhost test (vagrant)
        // $url = 'http://10.0.2.2:3000/wp-hugo';

        $response = wp_remote_post(
            $url,
            array('body' => array(
                'payload' => json_encode($instructions)
            ))
        );
        // $response = wp_remote_get( $url );

        if (is_wp_error($response)) {
            $frontRes = $response->get_error_message();
        } else {
            $frontRes = $response['body'];
        }

        // for logging
        // $hugo = SITE_ROOT."/wp-content/plugins/wordpress-hugopress/hugo_log.txt";
        // $this->estLogger($hugo);
        // $this->logger->putLog($frontRes);
        return "<p id='hugo'>$frontRes</p>";
    }

    /**
     * Builds actions into commands for hugo build process, then
     * passes instructions to API post function
     *
     * Called on multitude of hooks.
     *
     * @param int $post_id Post ID.
     */
    public function instructHugo($id, $content)
    {
        $url = get_option('hugopress-rest-input');
        if ($this->checkHugoAPIStatus($url)) {
            $this->postHugoAPI(
                $this->parseAction($this->app->action, $id, $content),
                $url.'hugopress-build'
            );
        }
    }

    // Determine what kind of build command to pass API
    public function parseAction($action, $id, $content)
    {
        $endpoint = strrpos($action, 'page') ? 'build-page' : 'build-generic';
        // 'text' => $command,
        return array(
            'endpoint' => $endpoint,
            'action' => $action,
            'id' => $id,
            'content' => $content,
            'testing' => true,
        );
    }

    // Makes output to wordpress look a little better
    public function hugo_css()
    {
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
