<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\cache\CacheManager::warmUpControllers([
	'controllers\\DbPgRaw',
	'controllers\\FortunesRaw'
]);

$workerServer->onWorkerStart = function () use ($config) {
	$db = \Ubiquity\db\Database::start('raw', $config);
	$db->prepareNamedStatement('fortune', 'SELECT id,message FROM Fortune');
	controllers\DbPgRaw::warmup($db);
};

