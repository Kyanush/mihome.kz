<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Address;
use App\Models\Company;
use App\Requests\SaveUserRequest;
use App\User;
use Illuminate\Http\Request;
use DB;

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
    public function save(SaveUserRequest $request)
    {
        $data = $request->input('user');

        $user = User::findOrNew($data["id"]);

        if (empty($data['password']))
            unset($data['password']);
        else
            $data['password'] = bcrypt($data['password']);

        $user->fill($data);

        return  $this->sendResponse($user->save() ? $user->id : false);
    }



    public function view($id)
    {
        $user = User::findOrFail($id);
        return $this->sendResponse($user);
    }


    public function delete($id)
    {
        $user = User::find($id);
        return  $this->sendResponse($user->delete() ? true : false);
    }





}
