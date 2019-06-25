<?
$pages = [];
$pagesDirs = glob(WEB_ROOT . '/views/*', GLOB_ONLYDIR);
foreach($pagesDirs as $dirP){
	@$dir = array_pop(explode('/',$dirP));
	$page = json_decode(file_get_contents(WEB_ROOT."/views/$dir/view.json"),true);
	if(!$page['hidden']) $pages[$dir] = $page;
}
?>
<ul class="navigation">
	<li class="navigationTitle">Sidor</li>
	<? foreach($pages as $pageP=>$page): ?>
	<li class="navigationLink">
		<a title="<?= $page['description'] ?>" href="<?= ($_SERVER['HTTPS']==='off' ? 'https://':'http://').$_SERVER['HTTP_HOST'].'/'.$pageP.'?'.$_SERVER['QUERY_STRING'] ?>"><?= $page["name"] ?></a>
	</li>
	<? endforeach ?>
</ul>
