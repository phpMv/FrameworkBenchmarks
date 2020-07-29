<?php
return array(
	"database" => [
		'pgsql' => [
			"wrapper" => "\\Ubiquity\\db\\providers\\pdo\\PDOWrapper",
			"type" => "pgsql",
			"dbName" => "hello_world",
			"serverName" => "tfb-database", // tfb-database
			"port" => 5432,
			"user" => "benchmarkdbuser", // benchmarkdbuser
			"password" => "benchmarkdbpass", // benchmarkdbpass
			"options" => [
				\PDO::ATTR_PERSISTENT => true
			],
			"cache" => false
		]
	],
	"test" => false,
	"debug" => false,
	"templateEngine" => "Ubiquity\\views\\engine\\Twig",
	"templateEngineOptions" => array(
		"cache" => false
	),
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
