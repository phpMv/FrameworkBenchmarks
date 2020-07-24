<?php
namespace controllers;

use models\Fortune;
use controllers\utils\FortunesTrait;

class Fortunes_ extends \Ubiquity\controllers\SimpleViewAsyncController {
	use FortunesTrait;

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('text/html', 'utf-8');
	}

	public function index() {
		$fortunes = \Ubiquity\orm\DAO::executePrepared('fortune');
		$fortunes[] = new Fortune(0, 'Additional fortune added at request time.');
		\usort($fortunes, 'self::compare');
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}
}

