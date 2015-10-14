<?php

namespace SlackBot;

use GuzzleHttp\Client as HTTPClient;
use WebSocket\Client as WSClient;

class API {

  protected $config;
  protected $slack_url = 'https://slack.com/api/';
  protected $request_object;
  protected $real_time_connection;
  protected $bot;

  public function __construct(Config $config, Core $bot) {
    $this->config = $config;
    $this->bot = $bot;
  }

  protected function connect() {
    $ws_url = $this->start_rtm();
    $this->real_time_connection = new WSClient($ws_url);
    $this->send('ping', ['id' => $this->bot->getIncrement()]);
  }

  protected function start_rtm() {
    $return = $this->request('rtm.start', array('no_unreads' => true));
    if (!isset($return->url)) {
      Throw new Exception('Could not get rtm url.');
    }
    return $return->url;
  }

  protected function request($method, $data) {
    $data['token'] = $this->config->get('token');
    $client = new HTTPClient(['base_uri' => $this->slack_url]);
    $request = $client->request('POST', $method, ['form_params' => $data]);


    $body =  $request->getBody();
    return json_decode($body);
  }

  public function listen() {
    if (!isset($this->real_time_connection)) {
      $this->connect();
    }

    return $this->real_time_connection->receive();
  }

  public function send($type, $data) {
    $data['type'] = $type;
    $json = json_encode($data);
    $this->real_time_connection->send($json);
  }
}