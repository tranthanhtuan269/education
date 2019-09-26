<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Backends\Requests\StoreRoleRequest;
use App\Http\Controllers\Backends\Requests\UpdateRoleRequest;
use App\Permission;
use App\Role;
use App\User;
use App\UserRole;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $roles_id = UserRole::where('user_id', $user_id)->pluck('role_id');
        $roles = Role::whereIn('id', $roles_id)->get();
        $str_privileges = '';
        foreach ($roles as $key => $value) {
            $str_privileges .= $value->permission;
            $str_privileges .= (count($roles) > 0 && $key < (count($roles) - 1)) ? "," : "";
        }

        $list_roles = explode(',', $str_privileges);
        $arr_privilegs_id = array_unique($list_roles);
        $data = Permission::get()->toArray();

        $roles = Role::select('id', 'name')->get();
        return view('backends.role.index', ['roles' => $roles, 'data' => $data, 'list_privilegs' => $arr_privilegs_id]);
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

        if (Role::create($input)) {
            $res = array('status' => "200", "Message" => "Thêm mới thông tin thành công");
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
        if ($role) {
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
        if ($role) {
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
        if ($role) {
            $role->name = $request->name;
            $role->permission = $request->permission;
            $role->updated_at = date('Y-m-d H:i:s');

            if ($role->save()) {
                $res = array('status' => "200", "Message" => "Cập nhật thông tin thành công");
            } else {
                $res = array('status' => "401", "Message" => "Cập nhật thông tin không thành công!");
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
        if (isset($id)) {
            if (UserRole::where('role_id', $id)->first()) {
                $res = array('status' => "204", "Message" => "Vai trò đã tồn tại với người dùng");
            } else {
                $role = Role::find($id);

                if (isset($role) && $role->delete()) {
                    $res = array('status' => "200", "Message" => "Xóa thông tin thành công");
                } else {
                    $res = array('status' => "204", "Message" => "Xóa thông tin không thành công!");
                }
            }
            echo json_encode($res);
        }
    }

    public function delMulti(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');
            $id_list = rtrim($id_list, ',');
            $arr_id_list = explode(",",$id_list);
        
            if (UserRole::whereIn('role_id', $arr_id_list)->first()) {
                $res = array('status' => "204", "Message" => "Trong danh sách chọn đã có ít nhất 1 vai trò đã tồn tại với người dùng!");
            } else {
                if (Role::deleteMulti($id_list)) {
                    $res = array('status' => 200, "Message" => "Đã xóa lựa chọn thành công");
                } else {
                    $res = array('status' => "204", "Message" => "Có lỗi trong quá trình xủ lý !");
                }
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

    public function getInfoByID($id)
    {
        if ($id) {
            $role = Role::find($id);
            if ($role) {
                $permission = rtrim($role->permission, ',');
                $permission_list = explode(",", $permission);

                $permissions = Permission::select('id', 'name', 'group')->orderby('group', 'asc')->get();
                $permission_root = Permission::where('group', 0)->orderBy('id', 'asc')->get();

                $html = '';
                foreach ($permission_root as $k => $p) {
                    $permission_child = Permission::where('group', $p->id)->get();
                    // echo count($permission_child).$p->name.'---';
                    if (count($permission_child) > 0) {
                        $html .= '<optgroup label="' . $p->name . '" class="group-' . $p->id . '">';
                        foreach ($permission_child as $key => $value) {
                            if (in_array($value->id, $permission_list)) {
                                $html .= '<option value="' . $value->id . '" selected="selected" class="group-' . $value->group . '">' . $value->name . '</option>';

                            } else {
                                $html .= '<option value="' . $value->id . '" class="group-' . $value->group . '">' . $value->name . '</option>';
                            }
                        }
                    }
                }
                $html .= '</optgroup>';

                return $html;
            }
        }
        return '';
    }
    public function getRoleByID($id)
    {
        if ($id) {
            $roles = Role::get();
            $arr_role_selected = UserRole::where('user_id', $id)->get()->filter(function($value, $key){
                if(isset($value->teacher)){ //duongnt
                    return $value->teacher->status == 1;
                }else{
                    return true;
                }
            })
            ->pluck('role_id')
            ->toArray();

            if ($roles) {
                $html = '';
                foreach ($roles as $value) {
                    if($value->id != 2 && $value->id != 3){
                        if (in_array($value->id, $arr_role_selected)) {
                            $html .= '<option value="' . $value->id . '" selected="selected">' . $value->name . '</option>';
                        } else {
                            $html .= '<option value="' . $value->id . '" >' . $value->name . '</option>';
                        }
                    }
                }
                return $html;
            }
        }
        return '';
    }
    public function suggestSearch(Request $request)
    {
        if (isset($request->text)) {
            $texts = Role::select('id', 'name as label', 'name as value')->where('name', 'like', '%' . $request->text . '%')->take(10)->get()->toJson();
            echo $texts;
        }
    }

    public function listpermission($id)
    {
        if (isset($id)) {
            $role = Role::find($id);
            $permissions = explode(",", $role['permission']);
            $retun = $result = "";
            if (count($permissions) > 0) {
                foreach ($permissions as $permission) {
                    $p = Permission::find($permission);
                    $retun .= $p['name'] . ", ";
                }

                $result = rtrim($retun, ", ");
            }
            $res = array('Response' => "Success", "Message" => "Successfully", 'result' => $result);
            echo json_encode($res);
        }
    }
}
