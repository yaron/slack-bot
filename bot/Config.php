<?php

namespace SlackBot;

class Config {
  protected $config;

  public function __construct() {
    $config = array();
    require __DIR__ . '/../config.php';
    $this->config = $config;
  }

  protected function get($key) {
    return isset($config[$key]) ? $config[$key] : NULL;
  }
}