<?php
namespace controllers\utils;

use Ubiquity\orm\core\prepared\DAONosqlPreparedQueryById;

trait DbAsyncTrait {

	/**
	 *
	 * @var DAONosqlPreparedQueryById
	 */
	protected static $pDao;

	public function __construct() {}

	public function initialize() {
		\Ubiquity\utils\http\UResponse::setContentType('application/json');
	}

	public static function warmup() {
		self::$pDao = new DAONosqlPreparedQueryById('models\\World');
	}
}

