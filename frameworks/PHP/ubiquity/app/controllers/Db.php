<?php
namespace controllers;

use Ubiquity\orm\SDAO;
use models\World;

/**
 * Bench controller.
 */
class Db extends \Ubiquity\controllers\Controller {

	public function __construct() {}

	public function initialize() {
		\header('Content-Type: application/json');
		\Ubiquity\cache\CacheManager::startProdFromCtrl();
	}

	public function index() {
		echo \json_encode((SDAO::getById(World::class, [
			'id' => \mt_rand(1, 10000)
		]))->_rest);
	}

	public function query($queries = 1) {
		$worlds = [];
		$count=static::getCount($queries);
		for ($i = 0; $i < $count; ++ $i) {
			$worlds[] = (SDAO::getById(World::class, [
				'id' => \mt_rand(1, 10000)
			]))->_rest;
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];

		$count=static::getCount($queries);
		$ids = $this->getUniqueRandomNumbers($count);
		foreach ($ids as $id) {
			$world = SDAO::getById(World::class, [
				'id' => $id
			]);
			$world->randomNumber = \mt_rand(1, 10000);
			SDAO::toUpdate($world);
			$worlds[] = $world->_rest;
		}
		SDAO::updateGroups($queries);

		echo \json_encode($worlds);
	}

	protected static function getCount($queries){
		$count=1;
		if($queries>1){
			if(($count =$queries)>500){$count=500;}
		}
		return $count;
	}

	private function getUniqueRandomNumbers($count) {
		$res = [];
		do {
			$res[\mt_rand(1, 10000)] = 1;
		} while (\count($res) < $count);

		\ksort($res); // prevent deadlocks (see https://github.com/TechEmpower/FrameworkBenchmarks/pull/5230#discussion_r345780701)

		return \array_keys($res);
	}
}
