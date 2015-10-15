<?php

namespace Controllers;


use SlackBot\Request;

class BeerController {
  public function Beer(Request $request) {
    $request->getCore()->getApiConnection()->getRTMSession()->sendMessage('Beer!', $request->getData()->channel);
  }
}