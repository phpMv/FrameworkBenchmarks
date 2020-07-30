<?php
namespace controllers;

use Ubiquity\orm\DAO;
use controllers\utils\DbTrait;
use controllers\utils\DbAsyncTrait;

/**
 * Bench controller.
 */
class SwooleDbAsync extends \Ubiquity\controllers\Controller {
	use DbTrait,DbAsyncTrait;

	public function index() {
		$dbInstance = DAO::pool('async');
		$world = self::$pDao->execute([
			'id' => \mt_rand(1, 10000)
		]);
		DAO::freePool($dbInstance);
		echo \json_encode($world->_rest);
	}

	public function query($queries = 1) {
		$count = $this->getCount($queries);
		$worlds = [];
		$dbInstance = DAO::pool('async');
		for ($i = 0; $i < $count; ++ $i) {
			$worlds[] = (self::$pDao->execute([
				'id' => \mt_rand(1, 10000)
			]))->_rest;
		}
		DAO::freePool($dbInstance);

		echo \json_encode($worlds);
	}
}
