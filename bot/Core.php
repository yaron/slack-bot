<?php

namespace SlackBot;

Class Core {

  protected $api_connection;

  public function __construct() {
    $this->api_connection = new API();
  }

  public function connect() {
    $this->api_connection->connect();
    while (true) {
      sleep(1);
      $this->listen();
    }
  }

  protected function listen() {
    $this->api_connection->listen();
  }
}