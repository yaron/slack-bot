<?php

namespace SlackBot\Controllers;


use SlackBot\Request;
use SlackBot\Services;
use GuzzleHttp\Client;

class YoutubeController {


  public function Youtube(Request $request) {
    $rtm_session = Services::load('API')->getRTMSession();

    $client = new Client(['base_uri' => 'https://www.googleapis.com/youtube/v3/']);
    $http_request = $client->get('search?part=id&q='
      . $request->getData()->text
      . '&type=video&key=AIzaSyAwBdOJqDwJkQynAjG55_Ag60ypWi8JZUM');
    $youtubes = json_decode($http_request->getBody());

    $message = 'https://www.youtube.com/watch?v=' . $youtubes->items[0]->id->videoId;


    $rtm_session->sendMessage($message, $request->getData()->channel);

  }
}