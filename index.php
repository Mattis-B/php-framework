<?
error_reporting(E_ALL);

ini_set('session.cookie_domain', '.mattisb.dev');

define('ROOT', __DIR__);
define('F_ROOT', ROOT.'/framework');
define('WEB_ROOT', ROOT.'/app');

// Class autoload
spl_autoload_register(function($class) {
  if(file_exists(F_ROOT . "/core/$class.php")){
    require_once F_ROOT . "/core/$class.php";
  } elseif(file_exists(WEB_ROOT . "/controllers/$class.php")) {
    require_once WEB_ROOT . "/controllers/$class.php";
  } elseif(file_exists(WEB_ROOT . "/models/$class.php")) {
    require_once WEB_ROOT . "/models/$class.php";
  }
});

if(preg_match("/\.ico$/",$_SERVER['PATH_INFO'])){
	header('Content-type: image/png; charset=utf-8');
	echo file_get_contents(WEB_ROOT."/ico/$_SERVER[PATH_INFO]");
	die();
}

session_start();


$URL = isset($_SERVER['PATH_INFO']) ? explode("/", ltrim($_SERVER['PATH_INFO'], "/")) : [];
{
	$host = explode(".", $_SERVER["HTTP_HOST"]);
	if(count($host)>=3 && $host[count($host)-3] !== "www"){
		array_unshift($URL, $host[count($host)-3]);
	}
}

require_once(F_ROOT . "/core/bootstrap.php");
