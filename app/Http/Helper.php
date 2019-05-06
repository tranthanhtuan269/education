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
}
