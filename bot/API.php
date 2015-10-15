<?php

namespace SlackBot;

use GuzzleHttp\Client as HTTPClient;

class API {

  protected $slack_url = 'https://slack.com/api/';
  protected $RTMSession;

  public function getRTMSession() {
    if (!(isset($this->RTMSession) && $this->RTMSession->connected())) {
      $ws_url = $this->start_rtm();
      $this->RTMSession = new RTMAPI($ws_url);
    }
    return $this->RTMSession;
  }

  protected function start_rtm() {
    $return = $this->request('rtm.start', array('no_unreads' => true));
    if (!isset($return->url)) {
      Throw new Exception('Could not get rtm url.');
    }
    return $return->url;
  }

  protected function request($method, $data) {
    $data['token'] = Services::load('Config')->get('token');
    $client = new HTTPClient(['base_uri' => $this->slack_url]);
    $request = $client->request('POST', $method, ['form_params' => $data]);

    $body =  $request->getBody();
    return json_decode($body);
  }
}
