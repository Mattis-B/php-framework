<?
class Controller extends Application {
	protected $_controller, $_action;
	public $view;

	function __construct($controller, $action){
		parent::__construct();
		$this->_controller = $controller;
		$this->_action = $action;
		$this->view = new View($controller);
	}

	function action($view){
		$this->view->render(strtolower(get_class($this)) . "/$view");
	}

	function fileAction($filePath){
		$controller = lcfirst($this->_controller);
		preg_match('/\..*/',end($filePath),$fileType);
		switch($fileType[0]){
			case '.js':
				header('content-type: text/javascript');
				$file = WEB_ROOT."/views/$controller/".implode('/',$filePath);
				if(!file_exists($file)){
					header('HTTP/1.1 404');
					die();
				}
				echo readfile($file);
				break;
			case '.css':
				header('content-type: text/css');
				$file = WEB_ROOT."/views/$controller/".implode('/',$filePath);
				if(!file_exists($file)){
					header('HTTP/1.1 404');
					die();
				}
				echo readfile($file);
				break;
			default:
				header('HTTP/1.1 404 Not found');
				die();
		}
	}
}
