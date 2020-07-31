<?php
namespace controllers;

use Ubiquity\orm\DAO;
use controllers\utils\DbAsyncTrait;

/**
 * Bench controller.
 */
class DbPg extends \Ubiquity\controllers\Controller {
	use DbAsyncTrait;

	public function index() {
		$world = self::$pDao->execute([
			'id' => \mt_rand(1, 10000)
		]);
		echo \json_encode($world->_rest);
	}

	public function query($queries = 1) {
		$worlds = [];
		$count = 1;
		($queries >= 1) ?: (($count = $queries) <= 500) ?: $count = 500;
		while ($count --) {
			$worlds[] = (self::$pDao->execute([
				'id' => \mt_rand(1, 10000)
			]))->_rest;
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$count = \min(\max($queries, 1), 500);

		while ($count --) {
			$world = self::$pDao->execute([
				'id' => \mt_rand(1, 10000)
			]);
			$world->randomNumber = \mt_rand(1, 10000);
			DAO::toUpdate($world);
			$worlds[] = $world->_rest;
		}
		DAO::flushUpdates();
		echo \json_encode($worlds);
	}
}
