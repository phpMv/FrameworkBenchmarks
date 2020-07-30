<?php
namespace controllers;

use models\Fortune;
use controllers\utils\FortunesTrait;
use controllers\utils\FortunesAsyncTrait;

class Fortunes_ extends \Ubiquity\controllers\SimpleViewAsyncController {
	use FortunesTrait,FortunesAsyncTrait;

	public function index() {
		$fortunes = self::$pDao->execute();
		$fortunes[] = new Fortune(0, 'Additional fortune added at request time.');
		\usort($fortunes, 'self::compare');
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}
}

