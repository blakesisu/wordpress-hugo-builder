<?php
/**
 * @package WordPress_Hugopress
 *
 * Abstract class used in all the sensors.
 * @see Sensors/*.php
 */
abstract class WPHB_AbstractSensor {
  /**
   * @var WordPress_Hugopress
   */
  protected $app;

  public function __construct(WordPress_Hugopress $app)
  {
      $this->app = $app;
  }

  abstract function HookEvents();

  public function addHooks($actions) {
    foreach ($actions as $action) {
      add_action($action, function($id, $content) use ($action) {
        $this->app->action = $action;
        // $this->app->compiler->mockHugoNotif();
        $this->app->compiler->instructHugo($id, $content);
      }, 10, 2);
    }
  }
}
