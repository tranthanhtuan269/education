<?php
namespace App;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Video;
use Auth;

class Helper {
	public static function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
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

	public static function createSecurityTokenForVideoLink($user_id, $video_id, $video_url){
		$wowza_serverip = "https://5dd0f175e72a1.streamlock.net:443"; //  ip/host
        $courdemysecure = 'courdemysecure'; 
		$courdemysecurestarttime = 0;
		$validity = 1800;
		$courdemysecureendtime = strtotime(date('d-m-Y H:i')) + $validity ;

		$courdemysecureCustomHash = hash('sha256', $user_id*$video_id, true);
		$courdemysecureCustomHash = strtr(base64_encode($courdemysecureCustomHash), '+/', '-_'); 
		
		$content_path = $video_url;
		//content_path example = vod/_definst_/dung-yeu-nua-em-met-roi-1080.mp4
		$secret = "zz725f4728cca67282";


		$hashstr = hash('sha256', $content_path.'?courdemysecureCustomHash='.$courdemysecureCustomHash.'&courdemysecureendtime='.$courdemysecureendtime.'&courdemysecurestarttime='.$courdemysecurestarttime.'&'.$secret, true);
		$usableHash = strtr(base64_encode($hashstr), '+/', '-_'); 
		
		return $wowza_serverip.'/'.$content_path.'/playlist.m3u8?courdemysecureCustomHash='.$courdemysecureCustomHash.'&courdemysecureendtime='.$courdemysecureendtime.'&courdemysecurestarttime=0&courdemysecurehash='.$usableHash."";
		// return $wowza_serverip.':1935/'.$content_path.'/playlist.m3u8?courdemysecureCustomHash='.$courdemysecureCustomHash.'&courdemysecureendtime='.$courdemysecureendtime.'&courdemysecurestarttime=0&courdemysecurehash='.$usableHash."";
	}

	public static function replace_key($arr, $oldkey, $newkey) {
        if(array_key_exists( $oldkey, $arr)) {
            $keys = array_keys($arr);
            $keys[array_search($oldkey, $keys)] = $newkey;
            return array_combine($keys, $arr); 
        }
            return $arr;    
	}
}
