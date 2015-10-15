<?php

namespace SlackBot;


class Route {
  public function match(Request $request, $match) {
    if (!isset($request->getData()->text)) {
      return FALSE;
    }
    return $request->getData()->text == $match;
  }
}
