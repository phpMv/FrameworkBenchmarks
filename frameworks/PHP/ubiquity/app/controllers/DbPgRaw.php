<?php
namespace controllers;

use controllers\utils\DbTrait;

/**
 * Bench controller.
 */
class DbPgRaw extends \Ubiquity\controllers\Controller {
	use DbTrait;

	protected static $statement;

	protected static $updates;

	protected static $db;

	public function __construct() {}

	public static function warmup($db) {
		self::$db = $db;
		self::$statement = $db->prepareStatement('SELECT id,randomNumber FROM World WHERE id=?::INTEGER LIMIT 1');
	}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public function index() {
		self::$statement->execute([
			\mt_rand(1, 10000)
		]);
		echo \json_encode(self::$statement->fetch());
	}

	public function query($queries = 1) {
		$worlds = [];
		$count = $this->getCount($queries);
		$st = self::$statement;
		while ($count --) {
			$st->execute([
				\mt_rand(1, 10000)
			]);
			$worlds[] = $st->fetch();
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$keys = $values = [];
		$count = $this->getCount($queries);
		$st = self::$statement;
		for ($i = 0; $i < $count; ++ $i) {
			$values[] = $keys[] = $id = \mt_rand(1, 10000);
			$st->execute([
				$id
			]);
			$row = $st->fetch();
			$values[] = $row['randomNumber'] = \mt_rand(1, 10000);
			$worlds[] = $row;
		}
		(self::$updates[$count] ?? self::prepareUpdate($count))->execute([
			...$keys,
			...$values
		]);
		echo \json_encode($worlds);
	}

	private static function prepareUpdate(int $count) {
		$sql = 'UPDATE World SET randomNumber = CASE id' . \str_repeat(' WHEN ?::INTEGER THEN ?::INTEGER ', $count) . 'END WHERE id IN (' . \str_repeat('?::INTEGER,', $count - 1) . '?::INTEGER)';
		return self::$updates[$count] = self::$db->prepareStatement($sql);
	}
}
