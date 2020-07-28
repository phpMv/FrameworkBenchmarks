<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\cache\CacheManager::warmUpControllers([
	'controllers\\DbPgRaw',
	'controllers\\FortunesRaw'
]);

$workerServer->onWorkerStart = function () use ($config) {
	\controllers\utils\RawDb::prepare($config);
};

