<?php

namespace SlackBot;

Class Core {

  protected $api_connection;
  protected $increment_id = 0;

  public function __construct(Config $config) {
    $this->config = $config;
    $this->api_connection = new API($this->config, $this);
  }

  public function connect() {
    while (true) {
      sleep(2);
      $this->listen();
    }
  }

  public function getIncrement() {
    return $this->increment_id++;
  }

  protected function listen() {
    $output = $this->api_connection->listen();
    $pong = FALSE;
    if ($output) {
      $data = json_decode($output);
      // router stuff
      if ($data->type == 'pong') {
        $pong = TRUE;
      }
    }

    if ($pong) {
      $this->api_connection->send('ping', ['id' => $this->getIncrement()]);
    }
  }
}