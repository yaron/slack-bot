<?php

namespace SlackBot;


class Services {
  protected static $services;
  protected static $instances;

  public static function init() {
    require __DIR__ . '/../services.php';
  }

  public static function load($service_name) {
    if (!isset(self::$instances[$service_name])) {
      if (isset(self::$services[$service_name])) {
        SELF::$instances[$service_name] = new self::$services[$service_name]();
      }
    }

    return SELF::$instances[$service_name];
  }

  protected static function set($service_name, $class) {
    self::$services[$service_name] = $class;
  }
}