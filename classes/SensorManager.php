<?php
/**
 * @package WPHB
 *
 * This Class load all the sensors and initialize them.
 */
final class WPHB_SensorManager extends WPHB_AbstractSensor {
  /**
   * @var WPHB_AbstractSensor[]
   */
  protected $sensors = array();


  /**
   * Instantiates a new SensorManager object
   *
   * @param WordPress_Hugo_Builder $app Application container.
   */
  public function __construct(WordPress_Hugo_Builder $app) {
    parent::__construct($app);
    $this->app = $app;

    foreach (glob(dirname(__FILE__) . '/sensors/*.php') as $file) {
        $this->AddFromFile($file);
    }

    /**
     * Load Custom Sensor files from /wp-content/uploads/wp-security-audit-log/custom-sensors/
     */
    // $upload_dir = wp_upload_dir();
    // $uploadsDirPath = trailingslashit($upload_dir['basedir']) . 'wp-security-audit-log' . DIRECTORY_SEPARATOR . 'custom-sensors' . DIRECTORY_SEPARATOR;
    // // Check directory
    // if (is_dir($uploadsDirPath) && is_readable($uploadsDirPath)) {
    //     foreach (glob($uploadsDirPath . '*.php') as $file) {
    //         require_once($file);
    //         $file = substr($file, 0, -4);
    //         $class = "WSAL_Sensors_" . str_replace($uploadsDirPath, '', $file);
    //         $this->AddFromClass($class);
    //     }
    // }
  }
  
  public function HookEvents() {
    foreach ($this->sensors as $sensor) {
        $sensor->HookEvents();
    }
  }
  
  public function GetSensors() {
    return $this->sensors;
  }
  
  /**
   * Add new sensor from file inside autoloader path.
   * @param string $file Path to file.
   */
  public function AddFromFile($file) {
    $this->AddFromClass($this->app->GetClassFileClassName($file));
  }
  
  /**
   * Add new sensor given class name.
   * @param string $class Class name.
   */
  public function AddFromClass($class) {
    $this->AddInstance(new $class($this->app));
  }
  
  /**
   * Add newly created sensor to list.
   * @param WSAL_AbstractSensor $sensor The new sensor.
   */
  public function AddInstance(WPHB_AbstractSensor $sensor) {
    $this->sensors[] = $sensor;
  }
}
