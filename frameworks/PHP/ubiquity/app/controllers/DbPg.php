<?php
namespace controllers;

use Ubiquity\orm\DAO;

/**
 * Bench controller.
 */
class DbPg extends \Ubiquity\controllers\Controller {
	private $numbers;

	public function __construct() {
		$this->numbers=\range(1,10000);
	}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public function index() {
		$world = DAO::executePrepared('world', [
			'id' => \mt_rand(1, 10000)
		]);
		echo \json_encode($world->_rest);
	}

	public function query($queries = 1) {
		$worlds = [];
		$queries = \min(\max($queries, 1), 500);
		$numbers=$this->getNumbers($queries);
		foreach ($numbers as $n) {
					$worlds[] = (DAO::executePrepared('world', [
						'id' => $this->numbers[$n]
			]))->_rest;
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$queries = \min(\max($queries, 1), 500);
		$numbers=$this->getNumbers($queries);
		foreach ($numbers as $n) {
			$world = DAO::executePrepared('world', [
				'id' => $this->numbers[$n]
			]);
			$world->randomNumber = \mt_rand(1, 10000);
			DAO::toUpdate($world);
			$worlds[] = $world->_rest;
		}
		DAO::flushUpdates();
		echo \json_encode($worlds);
	}

	protected function getNumbers($queries){
		if($queries==1){
			return [mt_rand(0,9999)];
		}else{
			return \array_rand($this->numbers,$queries);
		}
	}
}
