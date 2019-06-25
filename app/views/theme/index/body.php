<? $theme = isset($_COOKIE['theme']) ? json_decode($_COOKIE['theme'],true) : []; ?>
<form action="" method="post">
	<input type="color" name="primary"value="<?= isset($theme['primary']) ? $theme['primary'] : '#dddddd' ?>">
	<label for="primary" >Primary</label>
	<br/>
	<input type="color" name="secondary" value="<?= isset($theme['secondary']) ? $theme['secondary'] : '#aaaaaa' ?>">
	<label for="secondary">Secondary</label>
	<br/>
	<input type="color" name="backgroundColor" value="<?= isset($theme['backgroundColor']) ? $theme['backgroundColor'] : '#ffffff' ?>">
	<label for="backgroundColor">Background</label>
	<br/>
	<br/>
	<input style="" type="submit" value="Apply">
</form>