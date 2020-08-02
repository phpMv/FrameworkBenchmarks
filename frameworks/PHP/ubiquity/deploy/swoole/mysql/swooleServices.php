<?php
\Ubiquity\cache\CacheManager::startProd($config);
\Ubiquity\orm\DAO::setModelsDatabases([
	'models\\World' => 'default'
]);
\Ubiquity\cache\CacheManager::warmUpControllers([
	\controllers\DbMy::class
]);
$swooleServer->on('workerStart', function ($srv) use (&$config) {
	\Ubiquity\orm\DAO::startDatabase($config, 'default');
	\controllers\DbMy::warmup();
});
