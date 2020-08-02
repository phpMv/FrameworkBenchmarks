<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\orm\DAO::setModelsDatabases([
	'models\\Fortune' => 'mysql',
	'models\\World' => 'mysql'
]);

\Ubiquity\cache\CacheManager::warmUpControllers([
	\controllers\DbMy::class,
	\controllers\Fortunes_::class,
	\controllers\DbMy::class
]);

$workerServer->onWorkerStart = function () use ($config) {
	\Ubiquity\orm\DAO::startDatabase($config, 'mysql');
	\controllers\DbPg::warmup();
	\controllers\DbMy::warmup();
	\controllers\Fortunes_::warmup();
};

