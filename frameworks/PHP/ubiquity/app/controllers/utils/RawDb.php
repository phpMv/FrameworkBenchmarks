<?php
namespace controllers\utils;

class RawDb {

	private static $updates;

	private static $toUpdate;

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
		$sql = 'UPDATE World SET randomNumber = (CASE id' . \str_repeat(' WHEN ? THEN ? ', $count) . 'ELSE randomNumber END) WHERE id IN (' . \str_repeat('?::INTEGER,', $count - 1) . '?)';
		return self::$db->prepareStatement($sql);
	}

	public static function toUpdate($world) {
		self::$toUpdate['values'] += [
			$world['id'],
			self::$toUpdate['keys'][] = $world['randomNumber']
		];
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
