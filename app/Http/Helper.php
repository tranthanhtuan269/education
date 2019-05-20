<?php
namespace App;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class Helper {
    public static function checkPermissions($permission, $list_roles){
	    if (in_array($permission, $list_roles) || in_array('super-admin', $list_roles)) {
	     	return true;
		}  

		return false;
	}
		
	public static function convertSecondToTimeFormat($time){
		$hr = (int)($time / 3600);
		$min = (int)(($time % 3600) / 60);
		$sec = $time % 60;
		$sec_min = "";
		if($hr > 0){
				$sec_min = $sec_min . "" . $hr . ":" . ($min < 10 ? "0" : "");

		}
		$sec_min = $sec_min . "" . $min . ":" . ($sec < 10 ? "0" : "");
		$sec_min = $sec_min . "" . $sec;
		return $sec_min;
	}
}
