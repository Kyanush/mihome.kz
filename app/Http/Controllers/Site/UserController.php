<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

use App\Requests\ChangePasswordRequest;
use App\Requests\SaveAccountEditRequest;
use App\Tools\Helpers;
use Illuminate\Support\Facades\Auth;
use Redirect;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myAccount(){
        $user = Auth::user();
        return view('site.my_account', ['user' => $user]);
    }

    public function accountEdit(){
        $user = Auth::user();
        return view('site.account_edit', ['user' => $user]);
    }

    public function accountEditSave(SaveAccountEditRequest $request){
        $request = $request->input('account');
        $user = Auth::user();
        $user->name    = $request['name'];
        $user->surname = $request['surname'];
        $user->phone   = $request['phone'];
        $user->email   = $request['email'];
        $user->save();
        return Redirect::back()->with('success', 'Успешно изменено');
    }

    public function changePassword(){
        return view('site.change-password');
    }

    public function changePasswordSave(ChangePasswordRequest $request){
            $user = Auth::user();
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return Redirect::back()->with('success', 'Ваш пароль успешно изменен');
    }

}
