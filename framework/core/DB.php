<?
/**
 * Database
 * // NOTE: fix
 */
class DB
{
  protected static $_DB = null;

	protected static function _instantiate(){
		if(self::$_DB !== null) return;
		try {
			$config = json_decode(file_get_contents(ROOT.'/data/db.json'), true);
			self::$_DB = new PDO(/*host + db_name*/, $config['username'], $config['password'], [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false
			]);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

  public static function query($query, $params = []){
    return [];
		self::_instantiate();
		try {
			$q = self::$_DB->prepare($query);
			$q->execute($params);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
		return $q;
  }

	static function getTable($q){
		try {
			$data = [];
			$table = self::query('SELECT * FROM ' . $q);
			$data = $table->fetchAll();
		} catch(PDOException $e){
			echo $e->getMessage();
		}
		return $data;
	}
}
