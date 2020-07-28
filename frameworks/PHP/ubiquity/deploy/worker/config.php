<?php
return array(
	"database" => [
		'raw' => [
			"wrapper" => "\\Ubiquity\\db\\providers\\pdo\\PDOWrapper",
			"type" => "pgsql",
			"dbName" => "hello_world",
			"serverName" => "tfb-database", // tfb-database
			"port" => 5432,
			"user" => "benchmarkdbuser", // benchmarkdbuser
			"password" => "benchmarkdbpass", // benchmarkdbpass
			"options" => [
				\PDO::ATTR_PERSISTENT => true,
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
				\PDO::ATTR_EMULATE_PREPARES => false
			],
			"cache" => false
		]
	],
	"test" => false,
	"debug" => false,
	"cache" => [
		"directory" => "cache/",
		"system" => "Ubiquity\\cache\\system\\ArrayCache",
		"params" => []
	],
	"mvcNS" => [
		"models" => "models",
		"controllers" => "controllers",
		"rest" => ""
	]
);
