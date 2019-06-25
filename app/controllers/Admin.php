<?
class Admin extends Controller {
	function __construct($controller, $action){
		parent::__construct($controller, $action);
	}
	
	function action($view){
		if(USER["type"]!=="Admin") {
			require "/home/mattisx2/include/login.php";
			die();
		}
		$this->view->render(strtolower(get_class($this)) . "/" . implode("/",$view));		
	}
}