<?php

\Ubiquity\cache\CacheManager::startProd($config);

$workerServer->onWorkerStart = function () use ($config) {
	\Ubiquity\cache\CacheManager::warmUpControllers([
		'controllers\\DbPgRaw',
		'controllers\\FortunesRaw'
	]);
	\controllers\utils\RawDb::prepare($config);
};

