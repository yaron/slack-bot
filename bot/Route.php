<?php

namespace SlackBot;


class Route {
  protected $matchTypes = array(
    '*'  => '.+?',
    '#'  => '\#',
  );

  public function getRegex($match) {
    return '#^' . str_replace(array_keys($this->matchTypes), $this->matchTypes, $match) . '$#';
  }

  public function match(Request $request, $match) {
    if (!isset($request->getData()->text)) {
      return FALSE;
    }
    return preg_match($this->getRegex($match), $request->getData()->text);
  }
}
