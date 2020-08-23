<?php
namespace controllers;

use Ubiquity\orm\DAONosql;
use models\World;
use controllers\utils\DbTrait;

/**
 * Bench controller.
 */
class DbMongo extends \Ubiquity\controllers\Controller {
	use DbTrait;

	public function __construct() {}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public function index() {
		echo \json_encode((DAONosql::getById(World::class, [
			'id' => \mt_rand(1, 10000)
		]))->_rest);
	}

	public function query($queries = 1) {
		$worlds = [];
		$count = $this->getCount($queries);
		for ($i = 0; $i < $count; ++ $i) {
			$worlds[] = (DAONosql::getById(World::class, [
				'id' => \mt_rand(1, 10000)
			]))->_rest;
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];

		$count = $this->getCount($queries);
		$ids = $this->getUniqueRandomNumbers($count);
		foreach ($ids as $id) {
			$world = DAONosql::getById(World::class, [
				'id' => $id
			]);

			$world->randomNumber = \mt_rand(1, 10000);
			DAONosql::toUpdate($world);
			$worlds[] = $world->_rest;
		}

		DAONosql::flushUpdates(World::class);
		echo \json_encode($worlds);
	}

	private function getUniqueRandomNumbers($count) {
		$res = [];
		do {
			$res[\mt_rand(1, 10000)] = 1;
		} while (\count($res) < $count);

		\ksort($res);

		return \array_keys($res);
	}
}
