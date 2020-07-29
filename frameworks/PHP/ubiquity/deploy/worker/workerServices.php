<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\cache\CacheManager::warmUpControllers([
	'controllers\\DbPgRaw',
	'controllers\\FortunesRaw'
]);

$workerServer->onWorkerStart = function () use ($config) {
	$db = \Ubiquity\db\Database::start('raw', $config);
	$db->prepareNamedStatement('fortune', 'SELECT id,message FROM Fortune');
	$db->prepareNamedStatement('world', 'SELECT id,randomNumber FROM World WHERE id=?::INTEGER LIMIT 1');
};

