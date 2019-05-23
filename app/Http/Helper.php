<?php
namespace App;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Video;
use Auth;

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

	public static function createSecurityTokenForVideoLink($user_id, $video_id){
		$wowza_serverip = "http://45.56.82.249"; // your ip/host 
        $courdemysecure = 'courdemysecure'; 
		$courdemysecurestarttime = 0;
		$validity = 1800;
		$courdemysecureendtime = strtotime(date('d-m-Y H:i')) + $validity ;

		$courdemysecureCustomHash = hash('sha256', $user_id*$video_id, true);
		$courdemysecureCustomHash = strtr(base64_encode($courdemysecureCustomHash), '+/', '-_'); 
		
		$content_path = "vod/_definst_/killthislove1080.mp4";
		$secret = "zz725f4728cca67282";


		$hashstr = hash('sha256', $content_path.'?courdemysecureCustomHash='.$courdemysecureCustomHash.'&courdemysecureendtime='.$courdemysecureendtime.'&courdemysecurestarttime='.$courdemysecurestarttime.'&'.$secret, true);
		$usableHash = strtr(base64_encode($hashstr), '+/', '-_'); 
		
		return $wowza_serverip.':1935/'.$content_path.'/playlist.m3u8?courdemysecureCustomHash='.$courdemysecureCustomHash.'&courdemysecureendtime='.$courdemysecureendtime.'&courdemysecurestarttime=0&courdemysecurehash='.$usableHash."";
	}
}
