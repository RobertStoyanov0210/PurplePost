<?php
#  App Core Class
#  Creates URL & loads core controller
#  URL FORMAT -> /controller/method/params

class Core
{
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct()
  {
    $url = $this->getURL();

    if (isset($url[0])) {
      // Look in controllers for 1st value
      if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
        $this->currentController = ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);
      }
    }

    // Require the controller
    require_once '../app/controllers/' . $this->currentController . '.php';

    $this->currentController = new $this->currentController;

    // Check for second part of URL
    if (isset($url[1])) {
      if (method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
        // Unset 1 Index
        unset($url[1]);
      }
    }

    // Get params
    $this->params = $url ? array_values($url) : [];

    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getURL()
  {
    if (isset($_GET['url'])) {
      // Removes last '/' from url
      $url = rtrim($_GET['url'], '/');
      // Removes all illegal URL chars from a string
      $url = filter_var($url, FILTER_SANITIZE_URL);
      // Breaks url into array
      $url = explode('/', $url);
      return $url;
    }
  }
}
