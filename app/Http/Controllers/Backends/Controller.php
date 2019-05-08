<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Permission;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $list_roles;

    public function __construct() {
    	$this->middleware(['auth', 'clearance']);
    	$this->list_roles = [];
    	\View::share('list_roles', $this->list_roles);
    }
}
