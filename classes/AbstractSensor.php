<?php
/**
 * @package WordPress_Hugo_Builder
 *
 * Abstract class used in all the sensors.
 * @see Sensors/*.php
 */
abstract class WPHB_AbstractSensor {
  /**
   * @var WordPress_Hugo_Builder
   */
  // public $app;
  protected $app;

  public function __construct(WordPress_Hugo_Builder $app)
  {
      $this->app = $app;
  }

  abstract function HookEvents();
  
  /** protected function Log($type, $message, $args)
  {
      $this->plugin->alerts->Trigger($type, array(
          'Message' => $message,
          'Context' => $args,
          'Trace'   => debug_backtrace(),
      ));
  }
  
  protected function LogError($message, $args)
  {
      $this->Log(0001, $message, $args);
  }
  
  protected function LogWarn($message, $args)
  {
      $this->Log(0002, $message, $args);
  }
  
  protected function LogInfo($message, $args)
  {
      $this->Log(0003, $message, $args);
  }
 */

  /**
   * Check to see whether or not the specified directory is accessible
   * @param string $dirPath
   * @return boolean
   */
  /** protected function CheckDirectory($dirPath)
  {
      if (!is_dir($dirPath)) {
          return false;
      }
      if (!is_readable($dirPath)) {
          return false;
      }
      if (!is_writable($dirPath)) {
          return false;
      }
      return true;
  }
 */
}
