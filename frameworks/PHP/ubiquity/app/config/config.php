<?php
return array(
	"database" => [
		'default' => [
			"wrapper" => "\\Ubiquity\\db\\providers\\pdo\\PDOWrapper",
			"type" => "mysql",
			"dbName" => "hello_world",
			"serverName" => "tfb-database", // tfb-database
			"port" => 3306,
			"user" => "benchmarkdbuser", // benchmarkdbuser
			"password" => "benchmarkdbpass", // benchmarkdbpass
			"options" => [
				\PDO::ATTR_PERSISTENT => true
			],
			"cache" => false
		],
		'pgsql' => [
			"wrapper" => "\\Ubiquity\\db\\providers\\pgsql\\PgsqlWrapper",
			"type" => "pgsql",
			"dbName" => "hello_world",
			"serverName" => "tfb-database", // tfb-database
			"port" => 5432,
			"user" => "benchmarkdbuser", // benchmarkdbuser
			"password" => "benchmarkdbpass", // benchmarkdbpass
			"options" => [
				'async' => true,
				'pool_size' => 30
			],
			"cache" => false
		],
		'pgsql-cache' => [
			"wrapper" => "\\Ubiquity\\db\\providers\\pdo\\PDOWrapper",
			"type" => "pgsql",
			"dbName" => "hello_world",
			"serverName" => "tfb-database", // tfb-database
			"port" => 5432,
			"user" => "benchmarkdbuser", // benchmarkdbuser
			"password" => "benchmarkdbpass", // benchmarkdbpass
			"options" => [
				\PDO::ATTR_PERSISTENT => false
			],
			"cache" => false
		],
		'async' => [
			"wrapper" => "\\Ubiquity\\db\\providers\\swoole\SwooleWrapper",
			"type" => "mysql",
			"dbName" => "hello_world",
			"serverName" => "tfb-database", // tfb-database
			"port" => 3306,
			"user" => "benchmarkdbuser", // benchmarkdbuser
			"password" => "benchmarkdbpass", // benchmarkdbpass
			"options" => [],
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
