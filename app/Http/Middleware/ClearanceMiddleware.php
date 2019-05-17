<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Backends\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\UserRole;
use App\Permission;
use App\UserCourse;

class ClearanceMiddleware extends Controller{

    public function handle($request, Closure $next) { 

        $user_id = Auth::user()->id;
        $roles_id = UserRole::where('user_id', $user_id)->pluck('role_id');
        $roles =   Role::whereIn('id', $roles_id)->get();
        // echo '<pre>';
        // print_r($roles);die;
        $str_privileges = '';

        foreach ($roles as $key => $value) {
            $str_privileges .= $value->permission;
            $str_privileges .= (count($roles) > 0 && $key < (count($roles) - 1)) ? "," : "";
        }
        $list_roles = explode(',', $str_privileges);
        $list_roles = array_unique($list_roles);
        $this->list_roles = Permission::whereIn('id', $list_roles)->pluck('route')->toArray();
        \View::share('list_roles', $this->list_roles);

        // Super Admin thì muốn làm đéo gì thì làm
        if (in_array('super-admin', $this->list_roles)) {
            return $next($request);
        }

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