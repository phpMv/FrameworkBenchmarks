<?php
namespace controllers;

use models\Fortune;
use controllers\utils\FortunesAsyncTrait;

class FortunesMongo extends \Ubiquity\controllers\SimpleViewController {
	use FortunesAsyncTrait;

	public function index() {
		$fortunes = self::$pDao->execute();
		$fortunes[] = new Fortune(0, 'Additional fortune added at request time.');
		\usort($fortunes, function ($left, $right) {
			return $left->message <=> $right->message;
		});
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}
}

