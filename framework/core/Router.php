<?
class Router {
  public static function route($URL){
		$controller = (isset($URL[0]) && !empty($URL[0])) ? ucwords($URL[0]) : DEFAULT_CONTROLLER;
    $controller_name = $controller;
    array_shift($URL);

    $action = (isset($URL[0]) && !empty($URL[0])) ? $URL: array('index');
    $action_name = $action;

    if(file_exists(WEB_ROOT."/controllers/$controller.php")) $dispatch = new $controller($controller_name, $action);
    else {
      header('HTTP/1.0 404 Not Found');
      die();
    }
    if(preg_match('/\..*$/',end($action))){
			$dispatch->fileAction($action);
		} else {
			$dispatch->action($action);
		}
  }
}
