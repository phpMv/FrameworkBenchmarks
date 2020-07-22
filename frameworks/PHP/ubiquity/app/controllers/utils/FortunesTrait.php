<?php
namespace controllers\utils;

use models\Fortune;

trait FortunesTrait {
	public static function compare(Fortune $left, Fortune $right):int{
		return $left->message <=> $right->message;
	}
}

