<?php
namespace controllers\utils;

use Ubiquity\orm\core\prepared\DAONosqlPreparedQueryAll;

trait FortunesAsyncTrait {

	protected static $pDao;

	public static function warmup() {
		self::$pDao = new DAONosqlPreparedQueryAll('models\\Fortune');
	}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('text/html', 'utf-8');
	}
}

