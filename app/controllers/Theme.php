<?
class Theme extends Controller {
	function __construct($controller, $action){
		parent::__construct($controller, $action);
	}
	
	function action($view){
		$this->view->render(strtolower(get_class($this)) . "/" . implode("/",$view));		
	}
}