<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends AdminController
{

    public function list(Request $req)
    {
        $name = $req->input('name');
        $description = $req->input('description');

        $permissions = Permission::orderBy('description', 'asc')->where(function ($query) use ($name, $description){

            if($name)
                $query->where('name', 'like', "%$name%");

            if($description)
                $query->where('description', 'like', "%$description%");

        })->paginate($req->input('perPage', 100));

        return $this->sendResponse($permissions);
    }

    public function delete($permission_id){
        $permission = Permission::destroy($permission_id);
        return $this->sendResponse($permission);
    }

    public function save(Request $req){
        $id          = $req->input('id');

        $permission = Permission::findOrNew($id);
        $permission->fill($req->all());
        $permission->save();

        return $this->sendResponse($permission->id ?? false);
    }

    public function get($permission_id){
        $permission = Permission::find($permission_id);
        return $this->sendResponse($permission);
    }

}
