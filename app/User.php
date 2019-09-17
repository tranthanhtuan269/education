<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider_user_id', 'provider', 'facebook', 'google_id', 'phone', 'birthday', 'address', 'avatar', 'coins', 'bod', 'gender', 'bought', 'products', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public static function getDataForDatatable(){
        return \DB::table('users')->leftJoin('roles','roles.id', '=','users.role_id')
                ->select(
                        'users.id as id',
                        'users.name as name', 
                        'users.email as email',
                        'roles.name as role_name'
                        )
                ->selectRaw('DATE_FORMAT(users.created_at, "%d/%m/%Y %H:%i:%s") as created_at,users.id as id,users.name as name,users.email as email,roles.name as role_name');
        // $query = \DB::table('users')->leftJoin('roles','roles.id', '=','users.role_id')
        //         ->select(
        //                 'users.id as id',
        //                 'users.name as name', 
        //                 'users.email as email',
        //                 'roles.name as role_name'
        //                 )->get();
        // return $query;
    }

    public static function delMultiUser($id_list){
        $list = explode(",",$id_list);
        $checkUser = User::whereIn('id', $list);
        return ($checkUser->delete() > 0);
    }

    public static function checkUserByEmail($email){
        return User::where('email', $email)->first();
    }

    public static function resetPassword($user){
        $str_rand = str_random(10);
        
        \DB::table('users')
            ->where('id', $user)
            ->update(['password' => Hash::make($str_rand)]);
        return $str_rand;
    }

    public function userRoles()
    {
        return $this->hasMany('App\UserRole');
    }

    public function userRolesTeacher()
    {
        return $this->hasMany('App\UserRole')->where('role_id', \Config::get('app.teacher'))->first();
    }

    public function isTeacher(){
        $user_role_teacher = $this->hasMany('App\UserRole')->where('role_id', \Config::get('app.teacher'))->first();
        if(isset($user_role_teacher->teacher) && $user_role_teacher->teacher->status == 1){
            return true;
        }else{
            return false;
        }
    }

    public function isAdmin(){
        $user_role_admin = $this->hasMany('App\UserRole')->where('role_id', 1)->first();
        if(isset($user_role_admin)){
            return true;
        }else{
            return false;
        }
    }

    public function isStudent(){
        $user_role_student = $this->hasMany('App\UserRole')->where('role_id', 3)->first();
        if(isset($user_role_student)){
            return true;
        }else{
            return false;
        }
    }

    public function notOnlyStudent(){
        $user_role_count = $this->hasMany('App\UserRole')->count();
        if(isset($user_role_count)){
            if($user_role_count > 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    

    public function userRolesStudent()
    {
        return $this->hasMany('App\UserRole')->where('role_id', \Config::get('app.student'))->first();
    }

    public function user_emails()
    {
    	return $this->hasMany('App\UserEmail', 'user_id');
    }

    public function emails()
    {
    	return $this->belongsToMany('App\Email', 'user_email', 'user_id', 'email_id');
    }


}
