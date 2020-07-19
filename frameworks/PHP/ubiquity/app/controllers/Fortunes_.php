<?php
namespace controllers;

use models\Fortune;

class Fortunes_ extends \Ubiquity\controllers\SimpleViewAsyncController {

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('text/html', 'utf-8');
	}

	public function index() {
		$fortunes = \Ubiquity\orm\DAO::executePrepared('fortune');
		$fortunes[] = new Fortune(0, 'Additional fortune added at request time.');
		\usort($fortunes, 'self::compareToX');
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}

	private static function compareToX(Fortune $left, Fortune $right):int{
		return $left->message <=> $right->message;
	}
}

