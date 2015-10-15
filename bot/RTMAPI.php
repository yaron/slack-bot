<?php

namespace SlackBot;

use WebSocket\Client as WSClient;

class RTMAPI {
  
  protected $increment_id = 0;
  protected $url;
  protected $real_time_connection;
  
  public function __construct($url) {
    $this->url = $url;
    $this->connect();
  }
  
  protected function connect() {
    $this->real_time_connection = new WSClient($this->url);
    $this->ping();
  }

  public function getIncrement() {
    return $this->increment_id++;
  }  
  
  public function listen() {
    return $this->real_time_connection->receive();
  }

  public function send($type, $data) {
    $data['type'] = $type;
    $json = json_encode($data);
    $this->real_time_connection->send($json);
  }

  public function ping() {
    $this->send('ping', ['id' => $this->getIncrement()]);
  }
  
  public function connected() {
    return isset($this->real_time_connection);
  }

  public function sendMessage($message, $channel) {
    $this->send('message', [
      'id' => $this->getIncrement(),
      'text' => $message,
      'channel' => $channel,
    ]);
  }
}
