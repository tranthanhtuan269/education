<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\Role;
use App\UserRole;
use App\Permission;
use App\UserCourse;

class ClearanceFrontendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) { 
        \View::share('check_course_of_the_user', 0);

        if (Auth::check()) {
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

            // BaTV - kiểm tra xem user có học khóa học nào không
            $check_course_of_the_user = UserCourse::where('user_role_id', $user_id)->count();
            \View::share('check_course_of_the_user', $check_course_of_the_user);
        } else {

        }

        return $next($request);
    }
}
