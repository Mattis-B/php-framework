<?
$pages = [];
$pagesDirs = glob(WEB_ROOT . "/views/admin/*", GLOB_ONLYDIR);
foreach($pagesDirs as $dirP){
	$dir = array_pop(explode("/",$dirP));
	if(!in_array($dir, ["home", "admin"])){
		$page = json_decode(file_get_contents(WEB_ROOT."/views/admin/$dir/page.json"),true);
		$pages[$dir] = $page;
	}
}
?>
<table class="navigation">
	<thead>
		<th>Sidor</th>
	</thead>
	<tbody>
		<? foreach($pages as $pageP=>$page): ?>
		<tr>
			<td class="navigationLink">
				<a title="<?= $page["description"] ?>" href="<?= ($_SERVER["HTTPS"]==="off" ? "https://":"http://").$_SERVER["HTTP_HOST"]."/".$pageP ?>"><?= $page["name"] ?></a>
			</td>
		</tr>
		<? endforeach ?>
	</tbody>
</table>
