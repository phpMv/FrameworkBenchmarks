<?php
namespace controllers;

use Ubiquity\orm\DAO;
use models\Fortune;
use controllers\utils\FortunesAsyncTrait;
use controllers\utils\FortunesTrait;

class SwooleFortunesAsync extends \Ubiquity\controllers\SimpleViewAsyncController {
	use FortunesTrait,FortunesAsyncTrait{
		warmup as asyncWarmup;
	}

	protected static $db;

	public static function warmup() {
		self::asyncWarmup();
		self::$db = \Ubiquity\orm\DAO::getDatabase('async');
	}

	public function index() {
		$dbInstance = self::$db->pool();
		$fortunes = self::$pDao->execute();
		self::$db->freePool($dbInstance);
		$fortunes[] = (new Fortune())->setId(0)->setMessage('Additional fortune added at request time.');
		\usort($fortunes, 'self::compare');
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}
}

