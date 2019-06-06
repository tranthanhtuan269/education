<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Backends\Requests\StoreUserRequest;
use App\Http\Controllers\Backends\Requests\UpdateInfoRequest;
use App\Http\Controllers\Backends\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use App\Email;
use App\MailLog;
use App\UserRole;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        $users = User::select('id', 'name')->get();
        return view('backends.user.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreUserRequest $request)
    {
        // echo $request->password;die;
        $time_created = date('Y-m-d H:i:s');

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt(trim($request->password));
        $user->status = 1; // active
        $user->save();

        $user_id = $user->id;
        $created_at = $updated_at = date('Y-m-d H:i:s');
        $arr_roles = [];
        foreach ($request->role_id as $role) {
            $arr_roles[] = ['user_id' => $user_id, 'role_id' => $role, 'created_at' => $created_at, 'updated_at' => $updated_at];
        }
        UserRole::insert($arr_roles);

        $res = array('status' => "200", "Message" => "Thêm mới thông tin thành công");
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
        $user = User::find($id);
        if ($user) {
            return view('user.show', ['user' => $user]);
        } else {
            return view('error.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('user.edit', ['user' => $user]);
        } else {
            return view('error.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;


            if ($request->password != $user->password) {
                $user->password = bcrypt(trim($request->password));
            }

            $user->updated_at = date('Y-m-d H:i:s');

            UserRole::where('user_id', $id)->delete();
            $created_at = $updated_at = date('Y-m-d H:i:s');
            $arr_roles = [];
            foreach ($request->role_id as $role) {
                $arr_roles[] = ['user_id' => $id, 'role_id' => $role, 'created_at' => $created_at, 'updated_at' => $updated_at];
            }
            UserRole::insert($arr_roles);

            $res = array('status' => "200", "Message" => "Cập nhật thông tin thành công");

        } else {
            $res = array('status' => "401", "Message" => "Cập nhật thông tin không thành công!");
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
            $user = User::find($id);
            if (isset($user) && $user->delete()) {
                $res = array('status' => "200", "Message" => "Xóa thông tin thành công ");
            } else {
                $res = array('status' => "204", "Message" => "Xóa thông tin không thành công!");
            }
            echo json_encode($res);
        }
    }

    public function delMultiUser(Request $request)
    {
        if (isset($request) && $request->input('id_list')) {
            $id_list = $request->input('id_list');
            $id_list = rtrim($id_list, ',');

            if (User::delMultiUser($id_list)) {
                $res = array('status' => 200, "Message" => "Đã xóa lựa chọn thành công");
            } else {
                $res = array('status' => "204", "Message" => "Có lỗi trong quá trình xủ lý !");
            }
            echo json_encode($res);
        }
    }

    public function getDataAjax()
    {
        $users = User::get();
        return datatables()->collection($users)
            ->addColumn('role_name', function ($user) {
                $list_role = '';
                if (count($user->userRoles) > 0) {
                    foreach ($user->userRoles as $key => $value) {
                        if ($value->role->name) {
                            $list_role .= $value->role->name .',';
                        }
                    }
                }
                return substr($list_role, 0, -1);
            })
            ->addColumn('action', function ($user) {
                return $user->id;
            })
            ->addColumn('rows', function ($user) {
                return $user->id;
            })
            ->removeColumn('id')->make(true);
    }


    public function getEmailAjax()
    {
        $emails = MailLog::get();
        return datatables()->collection($emails)
            ->addColumn('action', function ($mail) {
                return $mail->id;
            })
            ->addColumn('rows', function ($mail) {
                return $mail->id;
            })
            ->removeColumn('id')->make(true);
    }

    public function getInfoByID($id)
    {
        $user = User::find($id);
        // echo '<pre>';
        // print_r($user);die;
        if ($user) {
            $res = array('status' => "200", "Message" => "Người dùng đã tồn tại!", "user" => $user);
        } else {
            $res = array('status' => "401", "Message" => "Người dùng không tồn tại!", "user" => null);
        }
        echo json_encode($res);
    }

    public function updateSefl(UpdateInfoRequest $request)
    {
        if (strlen($request->password) > 0 || strlen($request->repassword) > 0) {
            $this->validate($request, [
                'password' => 'min:8|max:100',
                'repassword' => 'min:8|max:100|same:password',
            ]);
        }

        $user = Auth::user();
        $user->name = $request->name;
        if (strlen($request->avatar) > 0) {
            $user->avatar = $request->avatar;
        }
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            $res = array('status' => "200", "Message" => "Cập nhật thông tin thành công", "user" => $user);
        } else {
            $res = array('status' => "401", "Message" => 'Người dùng không tồn tại.', "user" => null);
        }
        echo json_encode($res);
    }

    public function suggestSearch(Request $request)
    {
        if (isset($request->text)) {
            $texts = User::select('id', \DB::raw("CONCAT(name, ' - ', email) AS label"), 'name as value')
                ->where('name', 'like', '%' . $request->text . '%')
                ->orWhere('email', 'like', '%' . $request->text . '%')
                ->take(10)->get()->toJson();
            echo $texts;
        }
    }

    public function infoRoleUser(Request $request)
    {
        $result = Role::where('id', $request->role_id)->value('name');
        $res = array('Response' => "Success", "Message" => "Successfully", 'result' => $result);
        echo json_encode($res);
    }

    public function email(){
        $emails = MailLog::get();
        // dd($emails);
        $roles = Role::get();
        $users = User::select('id', 'name')->get();
        return view('backends.user.email', ['users' => $users, 'roles' => $roles]);
    }

    public function storeEmail(Request $request){
        if($request->content){
            $email = new MailLog;
            $email->title = $request->title;
            $email->content = $request->content;
            $email->create_user_id = Auth::id();
            $email->update_user_id = Auth::id();
            $email->save();

            return \Response::json(array('status' => '200', 'message' => 'Email is successfully stored!'));
        
        }else{
            return \Response::json(array('status'=> '404', 'message'=> 'Content cannot be null!'));
        }
    }

    public function editEmail(Request $request){
        $email = MailLog::find($request->id);
        if($email){
            if($request->content){
                $email->title = $request->title;
                $email->content = $request->content;
                $email->update_user_id = Auth::id();

                $email->save();
                
                return \Response::json(array('status' => '200', 'message' => 'Email is successfully updated!'));
                
            }else{
                return \Response::json(array('status' => '404', 'message' => 'Content cannot be null'));
            }
        }else{
            return \Response::json(array('status' => '404', 'message' => 'Cannot find the email'));
        }
    }
}
