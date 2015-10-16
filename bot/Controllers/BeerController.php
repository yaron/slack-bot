<?php

namespace SlackBot\Controllers;


use SlackBot\Request;
use SlackBot\Services;
use GuzzleHttp\Client;

class BeerController {
  protected $base_uri = 'http://www.ligthetbieralkoud.nl';
  protected $json_path = 'json.php';

  public function Beer(Request $request) {
    $rtm_session = Services::load('API')->getRTMSession();

    $client = new Client(['base_uri' => $this->base_uri]);
    $http_request = $client->get($this->json_path);
    $beer_data = json_decode($http_request->getBody());

    $messages = array();
    $messages[] = 'Staat het bier koud? *' . ($beer_data->cold ? 'Ja!' : 'Nee' ) . '*.';
    $messages[] = 'Wie moet er koud leggen? ' .  $beer_data->current_bringer . '.';
    $messages[] = 'Laatst bijgewerkt? ' . $beer_data->last_edit;
    $messages[] = 'https://www.youtube.com/watch?v=' . $beer_data->youtube;

    foreach ($messages as $message) {
      $rtm_session->sendMessage($message, $request->getData()->channel);
    }
  }
}