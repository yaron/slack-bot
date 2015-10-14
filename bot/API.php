<?php

namespace SlackBot;

use GuzzleHttp\Client;
use GuzzleHttp\Stream\StreamInterface;

class API {

  protected $token;
  protected $slack_url = 'https://slack.com/api/';
  protected $request_object;
  protected $real_time_connection;

  public function __construct() {
    $this->token = get_conf('token');
  }

  public function connect() {
    $this->real_time_connection = $this->start_rtm();
  }

  protected function start_rtm() {
    return $this->request('rtm.start', array('no_unreads' => true))->url;
  }

  protected function request($method, $data) {
    $data['token'] = $this->token;
    $client = new Client(['base_uri' => $this->slack_url]);
    $response = $client->post($method, ['form_params' => $data]);

    $body =  $response->getBody();
    return json_decode($body);
  }

  public function listen() {
    $client = new Client(['base_uri' => $this->real_time_connection]);
    $response = $client->get('');
    echo $response->getBody();
  }
}