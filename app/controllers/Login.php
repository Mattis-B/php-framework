<?
class Login extends Controller {
	function __construct($controller, $action){
		parent::__construct($controller, $action);
	}
	
	function action($view){
		if($_SESSION["user"]) {
			header("Location: /");
		} else {
			require ROOT."/include/login.php";
		}
	}
}