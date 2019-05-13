<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Permission;
use Validator,Cache;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::orderBy('id', 'asc')->get();
        // echo "<pre>";
        // print_r($permissions);
        // echo "</pre>";die;
        return view('backends.permission.index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backends.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $time_created = date('Y-m-d H:i:s');
        
        $input = $request->all();
        // echo "<pre>";
        // print_r($input);
        // echo "</pre>";die;
        $input['route'] = strtolower($input['route']);
        $input['created_at'] = $time_created;
        $input['updated_at'] = $time_created;
        unset($input['_token']);

        if(Permission::create($input)){
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $permission = Permission::find($id);
        if($permission){
            $permission->name         = $request->name;
            $permission->group        = $request->group;
            $permission->updated_at   = date('Y-m-d H:i:s');

            if($permission->save()){
                $res=array('status'=>"200","Message"=>"Cập nhật thông tin thành công!");    
            }else{
                $res=array('status'=>"401","Message"=>"Cập nhật thông tin không thành công!" );    
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
            $permission = Permission::find($id);
            if(isset($permission) && $permission->delete()){
                $res=array('status'=>"200","Message"=>"Xóa thông tin thành công");
            }else{
                $res=array('status'=>"204","Message"=>"Xóa thông tin không thành công!");
            }
            echo json_encode($res);
        }
    }

    public function delMulti(Request $request){
        if(isset($request) && $request->input('id_list')){
            $id_list = $request->input('id_list');
            $id_list = rtrim($id_list, ',');

            if(Permission::deleteMulti($id_list)){
                $res=array('status'=>200,"Message"=>"Đã xóa lựa chọn thành công");
            }else{
                $res=array('status'=>"204","Message"=>"Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function getDataAjax()
    {
        $permissions = Permission::get();
        return datatables()->collection($permissions)
            ->addColumn('group_name', function ($permission) {
                if($permission->parent){
                    return $permission->parent->name;
                }
                return "--";
            })
            ->addColumn('action', function ($permission) {
                return $permission->id;
            })
            ->addColumn('rows', function ($permission) {
                return $permission->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function suggestSearch(Request $request){
        if(isset($request->text)){
            $texts = Permission::select('id', 'name as label', 'name as value')->where('name', 'like', '%' . $request->text . '%')->take(10)->get()->toJson();
            echo $texts; 
        }
    }

}
