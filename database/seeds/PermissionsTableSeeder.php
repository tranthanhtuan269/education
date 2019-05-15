<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $per = new Permission; 
        $per->name = "Xem danh sách vai trò"; 
        $per->route = "users.list_roles"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Xem danh sách quyền"; 
        $per->route = "users.list_permissions"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Xóa vai trò"; 
        $per->route = "users.delete_roles"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Sửa vai trò"; 
        $per->route = "users.edit_roles"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Thêm vai trò"; 
        $per->route = "users.add_roles"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Xóa quyền"; 
        $per->route = "users.delete_permissions"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Chỉnh sửa quyền"; 
        $per->route = "users.edit_permissions"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Thêm quyền"; 
        $per->route = "users.add_permissions"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Xóa tài khoản"; 
        $per->route = "users.delete"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Chỉnh sửa tài khoản"; 
        $per->route = "users.edit"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Thêm tài khoản"; 
        $per->route = "users.add"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Duyệt đơn hàng"; 
        $per->route = "orders.aprove"; 
        $per->group = 57; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Quản lý đơn hàng"; 
        $per->route = "orders"; 
        $per->group = 0; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Full permission"; 
        $per->route = "super-admin"; 
        $per->group = 1; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Xem danh sách tài khoản"; 
        $per->route = "users.list"; 
        $per->group = 52; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Super Admin"; 
        $per->route = "admin"; 
        $per->group = 0; 
        $per->save(); 

        $per = new Permission; 
        $per->name = "Quản lý tài khoản"; 
        $per->route = "users"; 
        $per->group = 0; 
        $per->save(); 


        $role = new Role; 
        $role->name = "Super Admin"; 
        $role->permission = 2; 
        $role->save(); 
    }
}
