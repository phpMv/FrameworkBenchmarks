<?php
namespace controllers;

use Ubiquity\orm\DAONosql;
use models\Fortune;

class FortunesMongo extends \Ubiquity\controllers\SimpleViewController {

	public function initialize() {
		\Ubiquity\cache\CacheManager::startProdFromCtrl();
	}

	public function index() {
		$fortunes = DAONosql::getAll(Fortune::class);
		$fortunes[] = new Fortune(0, 'Additional fortune added at request time.');
		\usort($fortunes, function ($left, $right) {
			return $left->message <=> $right->message;
		});
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}
}

