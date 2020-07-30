<?php
\Ubiquity\cache\CacheManager::startProd($config);

\Ubiquity\orm\DAO::setModelsDatabases([
	'models\\World' => 'default',
	'models\\Fortune' => 'default'
]);

\Ubiquity\cache\CacheManager::warmUpControllers([
	\controllers\DbMy::class,
	\controllers\Fortunes_::class
]);

\Ubiquity\orm\DAO::startDatabase($config, 'default');
\controllers\DbMy::warmup();
\controllers\Fortunes_::warmup();

