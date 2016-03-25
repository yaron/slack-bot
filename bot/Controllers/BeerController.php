<?php

namespace SlackBot\Controllers;


use SlackBot\Request;
use SlackBot\Services;
use GuzzleHttp\Client;

class BeerController {
  public function Beer(Request $request) {
    $rtm_session = Services::load('API')->getRTMSession();

    $day = date('w');
    if ($day == 5) {
      $uri = Services::load('Config')->get('beer_json_uri');
      $last_slash = strrpos($uri, '/');
      $path = substr($uri, $last_slash + 1);
      $uri = substr($uri, 0, $last_slash);

      $client = new Client(['base_uri' => $uri]);
      $http_request = $client->get($path);
      $beer_data = json_decode($http_request->getBody());

      $messages = array();
      $messages[] = 'Staat het bier koud? *' . ($beer_data->cold ? 'Ja!' : 'Nee') . '*.';
      $messages[] = 'Wie moet er koud leggen? ' . $beer_data->current_bringer . '.';
      $messages[] = 'https://www.youtube.com/watch?v=' . $beer_data->youtube;

      foreach ($messages as $message) {
        $rtm_session->sendMessage($message, $request->getData()->channel);
      }
    }
    else {
      $rtm_session->sendMessage('Is het vrijdag of wat? Mogool.', $request->getData()->channel);
    }
  }
}
