<?php

namespace SlackBot\Controllers;


use SlackBot\Request;
use SlackBot\Services;

class YoutubeController {


  public function Sorry(Request $request) {
    $rtm_session = Services::load('API')->getRTMSession();
    $url = Services::load('Config')->get('dumb_url');

    $rtm_session->sendMessage($url, $request->getData()->channel);

  }
}
