<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Role;
use Auth;
use App\User;
use App\Permission;
use Validator,Cache;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_privilegs_id = Role::select('name','permission')->where('id',Auth::user()->role_id)->first();
        $arr_privilegs_id = explode(',', $list_privilegs_id->privileges_id);
        $data = Permission::get()->toArray();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";die;

        $roles = Role::select('id', 'name')->get();
        return view('backends.role.index', ['roles' => $roles, 'data'=>$data,'list_privilegs'=> $arr_privilegs_id, 'name' => $list_privilegs_id->name ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $time_created = date('Y-m-d H:i:s');
        $input = $request->all();
        $input['permission'] = $input['permission'];
        $input['created_at'] = $time_created;
        $input['updated_at'] = $time_created;
        unset($input['_token']);
        // unset($input['permission']);
        
        if(Role::create($input)){
            $res=array('status'=>"200","Message"=>"Thêm mới thông tin thành công");    
        }
        echo json_encode($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        if($role){
            return view('role.show');
        }

        return view('error.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        if($role){
            return view('role.edit', ['role' => $role]);
        }

        return view('error.404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::find($id);
        if($role){
            $role->name         = $request->name;
            $role->permission   = $request->permission;
            $role->updated_at   = date('Y-m-d H:i:s');

            if($role->save()){
                $res=array('status'=>"200","Message"=>"Cập nhật thông tin thành công");    
            }else{
                $res=array('status'=>"401","Message"=>"Cập nhật thông tin không thành công!");    
            }
        }
        echo json_encode($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id)){
            if ( User::where('role_id', $id)->first() ) {
                $res=array('status'=>"204","Message"=>"Vai trò đã tồn tại với người dùng");
            } else{
                $role = Role::find($id);

                if(isset($role) && $role->delete()){
                    $res=array('status'=>"200","Message"=>"Xóa thông tin thành công");
                }else{
                    $res=array('status'=>"204","Message"=>"Xóa thông tin không thành công!");
                }
            }
            echo json_encode($res);
        }
    }

    public function delMulti(Request $request){
        if(isset($request) && $request->input('id_list')){
            $id_list = $request->input('id_list');
            $id_list = rtrim($id_list, ',');

            if(Role::deleteMulti($id_list)){
                $res=array('status'=>200,"Message"=>"Đã xóa lựa chọn thành công");
            }else{
                $res=array('status'=>"204","Message"=>"Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function getDataAjax()
    {
        $roles = Role::getDataForDatatable();

        return datatables()->of($roles)
                ->addColumn('action', function ($role) {
                    return $role->id;
                })
                ->addColumn('rows', function ($role) {
                    return $role->id;
                })
                ->removeColumn('id')->make(true);
    }

    public function getInfoByID($id){
        if($id){


            $role = Role::find($id);
            if($role){
                $permission = rtrim($role->permission, ',');
                $permission_list = explode(",",$permission);

                $permissions = Permission::select('id', 'name', 'group')->orderby('group', 'asc')->get();
                $permission_root = Permission::where('group', 0)->orderBy('id', 'asc')->get();

                $html = '';
                foreach ($permission_root as $k => $p) {
                    $permission_child = Permission::where('group', $p->id)->get();
                    // echo count($permission_child).$p->name.'---';
                    if (count($permission_child) > 0) {
                         $html .= '<optgroup label="'.$p->name.'" class="group-'.$p->id.'">';
                        foreach ($permission_child as $key => $value) {
                            if(in_array($value->id, $permission_list)){
                                $html .= '<option value="'.$value->id.'" selected="selected" class="group-'.$value->group.'">'.$value->name.'</option>';
                                
                            }else{
                                $html .= '<option value="'.$value->id.'" class="group-'.$value->group.'">'.$value->name.'</option>';
                            }
                        }
                    }
                }   
                $html .= '</optgroup>';

                return $html;
            }


            // $role = Role::find($id);
            // if($role){
            //     $permission = rtrim($role->permission, ',');
            //     $permission_list = explode(",",$permission);

            //     $permissions = Permission::select('id', 'name', 'group')->orderby('group', 'asc')->get();
            //     $group = 0;
            //     $html = '<optgroup label="Giao diện người dùng" class="group-0">';
            //     foreach ($permissions as $p) {
            //         if($p->group != $group){
            //             $html .= '</optgroup>';
            //             if($p->group == 2)
            //             $html .= '<optgroup label="Sản phẩm" class="group-'.$p->id.'">';
            //             if($p->group == 3)
            //             $html .= '<optgroup label="Khách hàng" class="group-'.$p->id.'">';
            //             if($p->group == 4)
            //             $html .= '<optgroup label="Tin tức" class="group-'.$p->id.'">';
            //             if($p->group == 5)
            //             $html .= '<optgroup label="Tài khoản quản trị" class="group-'.$p->id.'">';
            //             if($p->group == 6)
            //             $html .= '<optgroup label="Liên hệ" class="group-'.$p->id.'">';
            //             if($p->group == 7)
            //             $html .= '<optgroup label="Page" class="group-'.$p->id.'">';
            //             if($p->group == 8)
            //             $html .= '<optgroup label="Đơn hàng" class="group-'.$p->id.'">';
            //             $group = $p->group;
            //         }
            //         if(in_array($p->id, $permission_list)){
            //             $html .= '<option value="'.$p->id.'" selected="selected" class="group-'.$p->group.'">'.$p->name.'</option>';
                        
            //         }else{
            //             $html .= '<option value="'.$p->id.'" class="group-'.$p->group.'">'.$p->name.'</option>';
            //         }
            //     }
            //     $html .= '</optgroup>';

                // return $html;
            // }
        }
        return '';
    }

    public function suggestSearch(Request $request){
        if(isset($request->text)){
            $texts = Role::select('id', 'name as label', 'name as value')->where('name', 'like', '%' . $request->text . '%')->take(10)->get()->toJson();
            echo $texts; 
        }
    }

    public function listpermission($id){
        if(isset($id)){
            $role = Role::find($id);
            $permissions = explode(",",$role['permission']);
            $retun = $result = "";
            if(count($permissions) > 0){
                foreach ($permissions as $permission) {
                    $p = Permission::find($permission);
                    $retun .= $p['name'] . ", ";
                }

                $result = rtrim($retun,", ");
            }
            $res=array('Response'=>"Success","Message"=>"Successfully",'result'=>$result);
            echo json_encode($res);
        }
    }
}
