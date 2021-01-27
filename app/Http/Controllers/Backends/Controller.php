<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Permission;
use Cache;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $list_roles;

    public function __construct() {
        // ======START Đếm lượt visited======
        Cache::rememberForever('cache_visited', function () {
            return [];
        });

        $cache_visited = Cache::get('cache_visited');

        if (!isset($_COOKIE['cache_visited'])) {
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                      $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                      $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            }
            
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = $_SERVER['REMOTE_ADDR'];

            if(filter_var($client, FILTER_VALIDATE_IP)) {
                $ip = $client;
            } elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
                $ip = $forward;
            } else {
                $ip = $remote;
            }

            $cache_visited[]= ['created_at' => date('Y-m-d H:i:s'), 'ip' => $ip];
            Cache::put('cache_visited', $cache_visited, 14400); // 10*24*60 = 10 ngày
            setcookie('cache_visited', "cache_visited", time() + 86400 );// 1 day
        }
        // ======END Đếm lượt visited======
    	$this->middleware(['auth', 'clearance']);
    	$this->list_roles = [];
    	\View::share('list_roles', $this->list_roles);
    }
}
