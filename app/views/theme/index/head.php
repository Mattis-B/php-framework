<link rel="stylesheet" type="text/css" href="theme/index/style.css">
<?
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$theme = [];
	$theme['primary'] = htmlspecialchars($_POST['primary']);
	$theme['secondary'] = htmlspecialchars($_POST['secondary']);
	$theme['backgroundColor'] = htmlspecialchars($_POST['backgroundColor']);
	setcookie('theme',json_encode($theme), time()+60*60*24*365*20, '/');
	header('refresh: 0');
}
?>
