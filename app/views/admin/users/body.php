<? $usrTable = DB::getTable('Users') ?>
<div class="container">
	<ul class="responsive-table">
		<li class="table-header">
			<div class="col col-1">Type</div>
			<div class="col col-2">Name</div>
			<div class="col col-3">Privilege</div>
			<div class="col col-4">Permissions</div>
			<div class="col col-5">Data</div>
		</li>
		<? foreach($usrTable as $user): ?>
		<li class="table-row">
			<div class="col col-1" data-label="Type"><?= $user['type'] ?></div>
			<div class="col col-2" data-label="Name"><?= $user['name'] ?></div>
			<div class="col col-3" data-label="Privilege"><?= $user['privilege'] ?></div>
			<div class="col col-4" data-label="Data"><?= $user['permissions'] ?></div>
			<div class="col col-5" data-label="Data"><?= $user['data'] ?></div>
		</li>
		<? endforeach ?>
	</ul>
</div>