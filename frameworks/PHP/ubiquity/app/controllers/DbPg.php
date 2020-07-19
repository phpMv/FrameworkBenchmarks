<?php
namespace controllers;

use Ubiquity\orm\DAO;

/**
 * Bench controller.
 */
class DbPg extends \Ubiquity\controllers\Controller {

	public function __construct() {
	}

	protected static function getCount($queries){
		$count=1;
		if($queries>1){
			if(($count = $queries) > 500){$count = 500;}
		}
		return $count;
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
		$count=static::getCount($queries);
		for ($i = 0; $i < $count; ++ $i) {
					$worlds[] = (DAO::executePrepared('world', [
						'id' => \mt_rand(1, 10000)
			]))->_rest;
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$count=static::getCount($queries);

		for ($i = 0; $i < $count; ++ $i) {
			$world = DAO::executePrepared('world', [
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
