<?php
namespace controllers;

use Ubiquity\orm\SDAO;
use models\Fortune;
use controllers\utils\FortunesTrait;

class Fortunes extends \Ubiquity\controllers\SimpleViewController {
	use FortunesTrait;
	public function initialize() {
		\Ubiquity\cache\CacheManager::startProdFromCtrl();
	}

	public function index() {
		$fortunes = SDAO::getAll(Fortune::class);
		$fortunes[] = new Fortune(0, 'Additional fortune added at request time.');
		\usort($fortunes, 'self::compare');
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}
}

