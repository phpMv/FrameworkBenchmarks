<?php
namespace controllers;

use controllers\utils\RawDb;

class FortunesRaw extends \Ubiquity\controllers\SimpleViewAsyncController {


	public function index() {
		RawDb::$fortune->execute();
		$fortunes= RawDb::$fortune->fetchAll(\PDO::FETCH_KEY_PAIR);
		$fortunes[0] = 'Additional fortune added at request time.';
		\asort($fortunes);
		$this->loadView('Fortunes/raw.php', [
			'fortunes' => $fortunes
		]);
	}
}

