<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\orm\DAO::setModelsDatabases([
	'models\\Fortune' => 'pgsql'
]);

\Ubiquity\cache\CacheManager::warmUpControllers([
	'controllers\\Fortunes_twig'
]);
$workerServer->onWorkerStart = function () use ($config) {
	\Ubiquity\orm\DAO::startDatabase($config, 'pgsql');
	\Ubiquity\orm\DAO::prepareGetAll('fortune', 'models\\Fortune');
};

