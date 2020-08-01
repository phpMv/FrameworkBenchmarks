<?php
return array(
	"database" => [
		'raw' => [
			"wrapper" => "\\Ubiquity\\db\\providers\\pgsql\\PgsqlWrapper",
			"type" => "pgsql",
			"dbName" => "hello_world",
			"serverName" => "tfb-database", // tfb-database
			"port" => 5432,
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
