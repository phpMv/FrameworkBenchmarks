<?php
namespace controllers;

use Ubiquity\orm\DAO;
use controllers\utils\DbTrait;
use Ubiquity\orm\core\prepared\DAOPreparedQueryById;

/**
 * Bench controller.
 */
class DbPg extends \Ubiquity\controllers\Controller {
	use DbTrait;

	protected static $pDao;

	public function __construct() {}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public static function warmup() {
		self::$pDao = new DAOPreparedQueryById('models\\World');
	}

	public function index() {
		$world = self::$pDao->execute(['id' => \mt_rand(1, 10000)]);
		echo \json_encode($world->_rest);
	}

	public function query($queries = 1) {
		$worlds = [];
		$count = $this->getCount($queries);
		for ($i = 0; $i < $count; ++ $i) {
			$worlds[] = (self::$pDao->execute(['id' => \mt_rand(1, 10000)]))->_rest;
		}
		echo \json_encode($worlds);
	}

	public function update($queries = 1) {
		$worlds = [];
		$count = $this->getCount($queries);

		for ($i = 0; $i < $count; ++ $i) {
			$world = self::$pDao->execute(['id' => \mt_rand(1, 10000)]);
			$world->randomNumber = \mt_rand(1, 10000);
			DAO::toUpdate($world);
			$worlds[] = $world->_rest;
		}
		DAO::flushUpdates();
		echo \json_encode($worlds);
	}
}
