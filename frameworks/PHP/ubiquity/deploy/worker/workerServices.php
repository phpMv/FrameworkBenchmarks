<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\cache\CacheManager::warmUpControllers([
	\controllers\DbPgRaw::class,
	\controllers\FortunesRaw::class
]);

$workerServer->onWorkerStart = function () use ($config) {
	$db = \Ubiquity\db\Database::start('raw', $config);
	\controllers\DbPgRaw::warmup($db);
	\controllers\FortunesRaw::warmup($db);
};

