<?php
namespace controllers\utils;

class RawDb {

	private static $updates;

	private static $toUpdate = [
		'values' => [],
		'keys' => []
	];

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
		$sql = 'UPDATE World SET randomNumber = CASE id' . \str_repeat(' WHEN ?::INTEGER THEN ?::INTEGER ', $count) . 'END WHERE id IN (' . \str_repeat('?::INTEGER,', $count - 1) . '?::INTEGER)';
		return self::$db->prepareStatement($sql);
	}

	public static function toUpdate($world) {
		self::$toUpdate['values'][] = self::$toUpdate['keys'][] = $world['id'];
		self::$toUpdate['values'][] = $world['randomNumber'];
	}

	public static function update(int $count) {
		self::$updates[$count] ??= self::prepareUpdate($count);
		self::$updates[$count]->execute([
			...self::$toUpdate['values'],
			...self::$toUpdate['keys']
		]);
		self::$toUpdate['values'] = self::$toUpdate['keys'] = [];
	}
}
