<?php
namespace controllers;

use models\Fortune;
use Ubiquity\orm\core\prepared\DAOPreparedQueryAll;

class Fortunes_ extends \Ubiquity\controllers\SimpleViewAsyncController {

	protected static $pDao;

	public static function warmup() {
		self::$pDao = new DAOPreparedQueryAll('models\\Fortune');
	}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('text/html', 'utf-8');
	}

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

