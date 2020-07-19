<?php
namespace controllers;

use Ubiquity\orm\DAO;

/**
 * Bench controller.
 */
class SwooleDbAsync extends \Ubiquity\controllers\Controller {

	protected static function getCount($queries){
		$count=1;
		if($queries>1){
			if(($count =$queries)>500){$count=500;}
		}
		return $count;
	}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public function index() {
		$dbInstance = DAO::pool('async');

		$world = DAO::executePrepared('world', [
			'id' => \mt_rand(1, 10000)
		]);
		DAO::freePool($dbInstance);
		echo \json_encode($world->_rest);
	}

	public function query($queries = 1) {
		$count = self::getCount($queries);
		$worlds = [];
		$dbInstance = DAO::pool('async');
		for ($i = 0; $i < $count; ++ $i) {
			$worlds[] = (DAO::executePrepared('world', [
				'id' => \mt_rand(1, 10000)
			]))->_rest;
		}
		DAO::freePool($dbInstance);

		echo \json_encode($worlds);
	}
}
