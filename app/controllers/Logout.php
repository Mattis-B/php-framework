<?
class Logout extends Controller {
	function __construct($controller, $action){
		parent::__construct($controller, $action);
	}
	
	function action($view){
		if($_SESSION['user']) {
			unset ($_SESSION['user']);
		}
	}
}