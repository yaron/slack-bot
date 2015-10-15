<?php

namespace SlackBot;


class Route {
  public function match(Request $request, $match) {
    echo 'match';
    var_dump($request->getData());
    if (!isset($request->getData()->text)) {
      return FALSE;
    }
    return $request->getData()->text == $match;
  }
}
