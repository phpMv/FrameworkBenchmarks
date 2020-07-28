<?php
namespace controllers\utils;

class RawDb {
	private static $db;
	public static $fortunes;

	public static function prepare($config){
		self::$db=\Ubiquity\db\Database::start('raw',$config);
		self::$fortunes=self::$db->prepareStatement('SELECT id,message FROM Fortune');
	}
}

