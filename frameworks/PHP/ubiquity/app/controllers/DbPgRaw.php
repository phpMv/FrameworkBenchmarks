<?php
namespace controllers;

use controllers\utils\DbTrait;
use controllers\utils\RawDb;

/**
 * Bench controller.
 */
class DbPgRaw extends \Ubiquity\controllers\Controller {
	use DbTrait;

	public function __construct() {}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public function index() {
		RawDb::$worlds->execute([
			\mt_rand(1, 10000)
		]);
		echo \json_encode(RawDb::$worlds->fetch());
	}

	public function query($queries = 1) {
		$worlds = [];
		$count = self::getCount($queries);
		while ($count --) {
			RawDb::$worlds->execute([
				\mt_rand(1, 10000)
			]);
			$worlds[] = RawDb::$worlds->fetch();
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$count = self::getCount($queries);

		for ($i = 0; $i < $count; ++ $i) {
			$id = \mt_rand(1, 10000);
			RawDb::$random->execute([
				$id
			]);
			$row = [
				'id' => $id,
				'randomNumber' => RawDb::$random->fetchColumn()
			];
			$row['randomNumber'] = \mt_rand(1, 10000);
			$worlds[] = $row;
		}
		RawDb::update($worlds);
		echo \json_encode($worlds);
	}
}
