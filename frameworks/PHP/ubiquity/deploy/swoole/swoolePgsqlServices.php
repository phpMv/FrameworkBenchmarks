<?php
\Ubiquity\cache\CacheManager::startProd($config);
\Ubiquity\orm\DAO::setModelsDatabases([
	\models\Fortune::class => 'pgsql',
	\models\World::class => 'pgsql'
]);
\Ubiquity\cache\CacheManager::warmUpControllers([
	\controllers\Plaintext_::class,
	\controllers\Json_::class,
	\controllers\DbPg::class,
	\controllers\Fortunes_::class
]);
$swooleServer->on('workerStart', function ($srv) use (&$config) {
	\Ubiquity\orm\DAO::startDatabase($config, 'pgsql');
	\controllers\DbPg::warmup();
	\controllers\Fortunes_::warmup();
});
