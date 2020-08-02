<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\orm\DAO::setModelsDatabases([
	'models\\Fortune' => 'mysql',
	'models\\World' => 'mysql'
]);

\Ubiquity\cache\CacheManager::warmUpControllers([
	\controllers\DbMy::class,
	\controllers\Fortunes_::class,
	\controllers\Db_::class
]);

$workerServer->onWorkerStart = function () use ($config) {
	\Ubiquity\orm\DAO::startDatabase($config, 'mysql');
	\controllers\Db_::warmup();
	\controllers\DbMy::warmup();
	\controllers\Fortunes_::warmup();
};

