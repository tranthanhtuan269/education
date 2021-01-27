<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use App\Category;
use Cache;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $category_fixed;

    public function __construct()
    {
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
        $this->middleware(['clearance-frontend']);

        $categories = Category::where('parent_id',0)->get();
        $arr_id = [];
        foreach ($categories as $key=>$category){
            if (count($category->childrenHavingCourse) > 0){
                array_push($arr_id, $category->id);
            }
        }
        $this->category_fixed = Category::whereIn('id',$arr_id)->orderBy('menu_index', 'asc')->get();
        \View::share('category_fixed', $this->category_fixed);
    }
}
