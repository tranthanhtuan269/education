<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $category_fixed;
    public function __construct()
    {
        $this->category_fixed = Category::get();
        \View::share('category_fixed', $this->category_fixed);
    }
}
