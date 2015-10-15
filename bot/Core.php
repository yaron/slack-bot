<?php

namespace SlackBot;

Class Core {

  protected $api_connection;
  protected $router;

  public function __construct(Config $config, $api_class, Router $router) {
    $this->config = $config;
    $this->api_connection = new $api_class($this->config, $this);
    $this->router = $router;
  }

  public function connect() {
    while (true) {
      sleep(2);
      $this->listen();
    }
  }

  protected function listen() {
    $output = $this->api_connection->getRTMSession()->listen();
    $pong = FALSE;
    if ($output) {
      $data = json_decode($output);
      $request = new Request($data, $this);
      $this->router->match($request);

      if (isset($data->type) && $data->type == 'pong') {
        $pong = TRUE;
      }
    }

    // Only send a ping if we got a pong. That way we never send more pings than
    // we get pongs. If we did we'd create a long queue of pongs that will add
    // increasing latency to the bot.
    if ($pong) {
      $this->api_connection->getRTMSession()->ping();
    }
  }

  public function getApiConnection() {
    return $this->api_connection;
  }
}
