<?php
return [
	'host' => '0.0.0.0',
	'port' => 8080,
	'options' => [
		'socket' => [
			'max_request' => 10000000000,
			'transport' => 'tcp',
			'max_package_size' => 10 * 1024 * 1024
		],
		'debug' => false
	]
];