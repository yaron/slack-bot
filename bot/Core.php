<?php

namespace SlackBot;

Class Core {
  public function connect() {
    while (true) {
      sleep(2);
      $this->listen();
    }
  }

  protected function listen() {
    $output = Services::load('API')->getRTMSession()->listen();
    $pong = FALSE;
    if ($output) {
      $data = json_decode($output);

      $request = new Request($data, $this);
      Services::load('Router')->match($request);

      if (isset($data->type) && $data->type == 'pong') {
        $pong = TRUE;
      }
    }

    // Only send a ping if we got a pong. That way we never send more pings than
    // we get pongs. If we did we'd create a long queue of pongs that will add
    // increasing latency to the bot.
    if ($pong) {
      Services::load('API')->getRTMSession()->ping();
    }
  }
}
