<?php
return array(
	"#tableName" => "world",
	"#primaryKeys" => array(
		"id" => "id"
	),
	"#manyToOne" => array(),
	"#fieldNames" => array(
		"id" => "id",
		"randomNumber" => "randomnumber"
	),
	"#fieldTypes" => array(
		"id" => "int(11)",
		"randomNumber" => "int(11)"
	),
	"#nullable" => array(),
	"#notSerializable" => array(),
	"#transformers" => array(),
	"#accessors" => array(
		"id" => "setId",
		"randomNumber" => "setRandomNumber"
	)
);
