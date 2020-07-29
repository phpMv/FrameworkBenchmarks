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
		self::$worlds = self::$db->prepareStatement('SELECT id,randomNumber FROM World WHERE id=?::INTEGER LIMIT 1');
		self::$random = self::$db->prepareStatement('SELECT randomNumber FROM World WHERE id=?::INTEGER LIMIT 1');
	}

	private static function prepareUpdate(int $count) {
		$sql = 'UPDATE World SET randomNumber = CASE id' . \str_repeat(' WHEN ?::INTEGER THEN ?::INTEGER ', $count) . 'END WHERE id IN (' . \str_repeat('?::INTEGER,', $count - 1) . '?::INTEGER)';
		return self::$updates[$count] = self::$db->prepareStatement($sql);
	}

	public static function update(array $worlds) {
		$values = [];
		$keys = [];
		foreach ($worlds as $world) {
			$values[] = ($keys[] = $world['id']);
			$values[] = $world['randomNumber'];
		}
		$count = \count($worlds);
		(self::$updates[$count] ?? self::prepareUpdate($count))->execute([
			...$values,
			...$keys
		]);
	}
}
