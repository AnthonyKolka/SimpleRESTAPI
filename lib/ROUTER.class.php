<?php
class ROUTER
{
  protected $controller = '';
  protected $routes = [];

  public function __construct($routes, $config)
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $this->routes = $routes[$method];
    $request_controller = strtok( strtok(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL), '/'), '?');
    $className = $request_controller.'_controller';
    if(in_array($request_controller, $this->routes))
    {
      $rawData = file_get_contents('php://input');
      if($config['debug'])
      {
        error_log("$method:$request_controller:$rawData");
      }
      $data = json_decode($rawData);
      require_once($config['app_root'] . "/controllers/$className.php");
      $this->controller = new $className($data, $config);
      if(method_exists($this->controller, $method))
      {
        try
        {
          $this->controller->$method();
        }
        catch(exception $e)
        {
          http_response_code(500);
          error_log("$className $method : " . $e->getMessage());
        }
      }
      else
      {
        http_response_code(404);
      }
    }
    else
    {
      http_response_code(404);
    }
  }
}