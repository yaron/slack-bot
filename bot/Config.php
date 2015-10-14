<?php

namespace SlackBot;

class Config {
  protected $config;

  public function __construct() {
    $config = array();
    require __DIR__ . '/../config.php';
    $this->config = $config;
  }

  public function get($key) {
    return isset($this->config[$key]) ? $this->config[$key] : NULL;
  }
}