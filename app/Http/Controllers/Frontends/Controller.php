<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use App\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $category_fixed;

    public function __construct()
    {

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
