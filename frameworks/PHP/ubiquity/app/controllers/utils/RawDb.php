<?php
namespace controllers\utils;

class RawDb {

	private static $updates;

	private static $db;

	public static $fortunes;

	public static $worlds;

	public static $random;

	public static function prepare(array $config) {
		self::$db = \Ubiquity\db\Database::start('raw', $config);
		self::$fortunes = self::$db->prepareStatement('SELECT id,message FROM Fortune');
		self::$worlds = self::$db->prepareStatement('SELECT id,randomNumber FROM World WHERE id=?');
		self::$random = self::$db->prepareStatement('SELECT randomNumber FROM World WHERE id=?');
	}

	private static function prepareUpdate(int $count) {
		$sql = 'UPDATE World SET randomNumber = CASE id' . \str_repeat(' WHEN ? THEN ? ', $count) . 'END WHERE id IN (' . \str_repeat('?,', $count - 1) . '?)';
		return self::$db->prepareStatement($sql);
	}

	public static function update(array $worlds) {
		$count = \count($worlds);
		self::$updates[$count] ??= self::prepareUpdate($count);
		$values = [];
		$keys = [];
		foreach ($worlds as $world) {
			$values[] = $keys[] = $world['id'];
			$values[] = $world['randomNumber'];
		}
		self::$updates[$count]->execute([
			...$values,
			...$keys
		]);
	}
}
