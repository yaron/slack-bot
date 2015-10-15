<?php

namespace SlackBot;

class Router {
  protected $routes = array();

	public function getRoutes() {
		return $this->routes;
	}
  
  public function map($type, $match, Route $route, $target, $name = null) {
    $this->routes[] = compact('type', 'match', 'route', 'target', 'name');
  }
  
  public function match(Request $request) {
    foreach ($this->routes as $route) {
      echo 'matching';
      if ($route['type'] == $request->getType()) {
        echo 'typematch';
        if ($route['route']->match($request, $route['match'])) {
          list($method, $class) = explode('@', $route['target']);
echo $class;
          $controller = new $class();
          $controller->$method($request);
        }
      }
    }
  }
}
