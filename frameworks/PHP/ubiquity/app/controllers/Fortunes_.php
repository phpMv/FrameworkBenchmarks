<?php
namespace controllers;

use models\Fortune;

class Fortunes_ extends \Ubiquity\controllers\SimpleCViewAsyncController {

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('text/html', 'utf-8');
	}

	public function index() {
		$fortunes = \Ubiquity\orm\DAO::executePrepared('fortune');
		$fortunes[] = new Fortune(0, 'Additional fortune added at request time.');
		\usort($fortunes, 'self::cmp');
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}

	private static function cmp(Fortune $a, Fortune $r):int{
		return $a->message <=> $r->message;
	}
}

