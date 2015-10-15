<?php

namespace SlackBot\Controllers;


use SlackBot\Request;
use SlackBot\Services;

class BeerController {
  public function Beer(Request $request) {
    Services::load('API')->getRTMSession()->sendMessage('Beer!', $request->getData()->channel);
  }
}