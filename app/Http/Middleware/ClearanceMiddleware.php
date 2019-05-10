<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Backends\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Permission;

class ClearanceMiddleware extends Controller{

    public function handle($request, Closure $next) {  
        
        $user   = Auth::user();
        $role_id = $user->role_id;
        $data =  Role::where('id', $role_id)->first();
        $arr = explode(',', $data->permission);  
        $data = Permission::find($arr);
        $list_roles = [];

        foreach ($data as $key => $value) {
            $list_roles[] = trim($value->route);
        }

        $this->list_roles = $list_roles;
        \View::share('list_roles', $this->list_roles);

        // Super Admin thì muốn làm đéo gì thì làm
        if (in_array('super-admin', $this->list_roles)) {
            return $next($request);
        }

        if ($request->is('admincp/users')) {
            if (in_array('users.list', $this->list_roles)) {
                return $next($request);
            } else {
                abort('401');
            }
        }

        if ($request->is('admincp/permissions')) {
            if (in_array('users.list_permissions', $this->list_roles)) {
                return $next($request);
            } else {
                abort('401');
            }
        }

        if ($request->is('admincp/roles')) {
            if (in_array('users.list_roles', $this->list_roles)) {
                return $next($request);
            } else {
                abort('401');
            }
        }
        // if ($request->is('posts/*/edit')) {
        //     if (!Auth::user()->hasPermissionTo('Edit Post')) {
        //         abort('401');
        //     } else {
        //         return $next($request);
        //     }
        // }

        // if ($request->isMethod('Delete')) {
        //     if (!Auth::user()->hasPermissionTo('Delete Post')) {
        //         abort('401');
        //     } else {
        //         return $next($request);
        //     }
        // }

        return $next($request);
    }
}