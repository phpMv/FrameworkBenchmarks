<?php
namespace controllers;

use controllers\utils\DbTrait;

/**
 * Bench controller.
 */
class DbPgRaw extends \Ubiquity\controllers\Controller {
	use DbTrait;

	protected static $statement;

	protected static $db;

	public function __construct() {}

	public static function warmup($db) {
		self::$db = $db;
		self::$statement = $db->prepareNamedStatement('world', 'SELECT id,randomNumber FROM World WHERE id=?::INTEGER LIMIT 1');
		;
	}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public function index() {
		self::$statement->execute([
			\mt_rand(1, 10000)
		]);
		echo \json_encode($this->statement->fetch());
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
		while ($count --) {
			$values[] = $keys[] = $id = \mt_rand(1, 10000);
			$st->execute([
				$id
			]);
			$row = $st->fetch();
			$values[] = $row['randomNumber'] = \mt_rand(1, 10000);
			$worlds[] = $row;
		}
		self::$db->getNamedStatement($count)->execute([
			...$keys,
			...$values
		]);
		echo \json_encode($worlds);
	}
}
