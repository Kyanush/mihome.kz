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


        if($user->save())
        {

            if(!empty($data['addresses']))
            {
                foreach ($data['addresses'] as $item)
                {
                    if(intval($item['is_delete']) == 1){
                        $user->addresses()->find($item["id"])->delete();
                    }else{
                        $address = $user->addresses()->findOrNew($item["id"]);
                        $address->fill($item);
                        $address->save();
                    }
                }
            }

            if(!empty($data['companies']))
            {
                foreach ($data['companies'] as $item)
                {
                    if(intval($item['is_delete']) == 1){
                        $user->companies()->find($item["id"])->delete();
                    }else{
                        $company = $user->companies()->findOrNew($item["id"]);
                        $company->fill($item);
                        $company->save();
                    }
                }
            }
        }

        return  $this->sendResponse($user->save() ? $user->id : false);
    }



    public function view($id)
    {
        $user = User::with(['addresses', 'companies'])->findOrFail($id);

        if($user){
            if($user->addresses)
            {
                $addresses = $user->addresses->map(function ($item){
                    return [
                        'id'        => $item->id,
                        'address'   => $item->address,
                        'city'      => $item->city,
                        'is_delete' => false
                    ];
                });
                unset($user->addresses);
                $user->addresses = $addresses;
            }
            if($user->companies)
            {
                $companies = $user->companies->map(function ($item){
                    return [
                        'id'        => $item->id,
                        'name'      => $item->name,
                        'address'   => $item->address,
                        'county'    => $item->county,
                        'city'      => $item->city,
                        'info'      => $item->info,
                        'is_delete' => false
                    ];
                });
                unset($user->companies);
                $user->companies = $companies;
            }

        }
        return $this->sendResponse($user);
    }


    public function delete($id)
    {
        $user = User::find($id);
        return  $this->sendResponse($user->delete() ? true : false);
    }





}
