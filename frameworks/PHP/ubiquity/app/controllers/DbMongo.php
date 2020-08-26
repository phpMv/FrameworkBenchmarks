<?php
namespace controllers;

use Ubiquity\orm\DAONosql;
use models\World;
use controllers\utils\DbTrait;
use controllers\utils\DbAsyncTrait;

/**
 * Bench controller.
 */
class DbMongo extends \Ubiquity\controllers\Controller {

	use DbTrait,DbAsyncTrait;

	public function index() {
		echo \json_encode((self::$pDao->execute([
			'id' => \mt_rand(1, 10000)
		]))->_rest);
	}

	public function query($queries = 1) {
		$worlds = [];

		$count = $this->getCount($queries);

		while ($count --) {
			$worlds[] = (self::$pDao->execute([
				'id' => \mt_rand(1, 10000)
			]))->_rest;
		}

		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$count = $this->getCount($queries);
		// $ids = $this->getUniqueRandomNumbers($count);
		$bId = DAONosql::startBulk(World::class);
		while ($count --) {
			$world = self::$pDao->execute([
				'id' => \mt_rand(1, 10000)
			]);
			do {
				$nRn = \mt_rand(1, 10000);
			} while ($world->randomNumber === $nRn);
			$world->randomNumber = $nRn;
			DAONosql::toUpdate($world, $bId);
			$worlds[] = $world->_rest;
		}
		DAONosql::flush($bId, true);

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
