<?php
namespace services;

use models\Fortune;

class Benchmark {
	public static function getCount($queries){
		$count=1;
		if($queries>1){
			if(($count =$queries)>500){$count=500;}
		}
		return $count;
	}

	public static function compareTo(Fortune $left, Fortune $right):int{
		return $left->message <=> $right->message;
	}
}

