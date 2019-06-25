<?
// Load config and helper functions
require_once ROOT . '/config/config.php';
require_once WEB_ROOT . '/lib/helpers/functions.php';

$USER = [];
/*if(isset($_SESSION['user'])){
	$users = DB::query("select * from Users where user=:user", ['user'=>$_SESSION['user']]);
	if($user = $users->fetch()){
		$USER = $user;
	} else {
		$users = DB::query("select * from Users where user=:user", ['user'=>'guest']);
		if($user = $users->fetch()){
			$USER = $user;
		}
	}
} else {
	$users = DB::query('select * from Users where user=:user', ['user'=>'guest']);
	if($user = $users->fetch()){
		$USER = $user;
	}
}*/

define('USER', $USER);

$debug = false;

if(USER['privilege']>4) $debug = isset($_REQUEST['debug']);

define('DEBUG', $debug);

if(DEBUG){
	ini_set('display_errors', 1);
} else {
	ini_set('display_errors', 0);
	ini_set('log_errors', 1);
}

// Routing
Router::route($URL);
