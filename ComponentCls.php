<?php
namespace Component;
class ComponentCls {
  private static $componentCache = array();
  public static $phase = 1;
  private static $projectId = '';
  private $componentId;

  function __construct($project, $component) {
    if (self::$projectId !== '' && self::$projectId !== $project) die('Only one project is allowed');
    switch (self::$phase) {
      case 1:
        self::$projectId = $project;
        self::$componentCache[$component] = array();
        break;
      case 2:
        $this->componentId = $component;
        break;
    }
  }

  public function __get($name) {
    if (self::$phase === 1) return null;
    if (array_key_exists($name, self::$componentCache[$this->componentId])) {
      return self::$componentCache[$this->componentId][$name];
    }
    $trace = debug_backtrace();
    trigger_error(
      'Undefined property on component ' . $this->componentId . ': ' . $name .
      ' in ' . $trace[0]['file'] .
      ' on line ' . $trace[0]['line'],
      E_USER_NOTICE);
    return null;
  }

  public function build_image($img, $tf) {
    $tfStr = implode(',', array_map(function ($k, $v) {
      return $k . '_' . $v;
    }, array_keys($tf), $tf));

    return str_replace('/image/upload/', '/image/upload/'.$tfStr.'/', $img);
  }

  static function _phase2() {
    self::$phase = 2;
    $uri = 'https://api.component.io/v0/data/' . self::$projectId .'/components/' . implode(',', array_keys(self::$componentCache));
    $response = \Httpful\Request::get($uri)->send();
    foreach($response->body as $obj) {
      self::$componentCache[$obj->key] = get_object_vars($obj->data);
    }
  }
}
