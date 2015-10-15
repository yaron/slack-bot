<?php

namespace SlackBot;


class Request {
  protected $data;
  protected $core;
  
  public function __construct($data, Core $core) {
    $this->data = $data;
    $this->core = $core;
  }
  
  public function getType() {
    return isset($this->data->type) ? $this->data->type : NULL;
  }
  
  public function getData() {
    return $this->data;
  }

  public function getCore() {
    return $this->core;
  }
}
