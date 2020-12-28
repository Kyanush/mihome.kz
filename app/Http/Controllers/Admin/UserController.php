<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Address;
use App\Models\Company;
use App\Requests\SaveUserRequest;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\Services\ServicePermission;

class UserController extends AdminController
{


    public function list(Request $request)
    {
        $list =  User::with('role')
            ->search($request->input('search'))
            ->role($request->input('role_id', 0))
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('perPage', 10));

        return  $this->sendResponse($list);
    }

    //SaveAttribute
    public function save(SaveUserRequest $req)
    {
        $data           = $req->input('user');
        $permission_ids = $req->input('permission_ids');

        $id             = $data['id'];
        $password       = $data['password'];

        $user = User::findOrNew($id);
        $user->fill($data);

        if($password)
            $user->password = bcrypt($password);

        if($user->save())
            $user->permissions()->sync($permission_ids);

        return $this->sendResponse($user->id ?? false);
    }



    public function view($id){
        $user = User::findOrFail($id);
      //  $roles_id = $user->roles->pluck('id')->toArray();
        $permission_ids = $user->permissions()->pluck('permission_id')->toArray();

        return $this->sendResponse([
            'user'           => $user,
           // 'roles_id'       => $roles_id,
            'permission_ids' => $permission_ids
        ]);
    }


    public function delete($id)
    {
        $user = User::find($id);
        return  $this->sendResponse($user->delete() ? true : false);
    }





}
