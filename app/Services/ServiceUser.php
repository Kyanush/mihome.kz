<?php
namespace App\Services;

use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class ServiceUser
{

    private static $role_id = 2;

    public static function createUser($email, $password, $name, $phone, $role_id = 0)
    {
        $data = [
            'name'     => $name,
            'email'    => $email,
            'phone'    => $phone,
            'role_id'  => $role_id > 0 ? $role_id : self::$role_id];

        if($password)
            $data['password'] = Hash::make($password);

        return User::create($data);
    }

    public static function findOrNewUserCart($email, $name, $phone){
        $user = User::where('email', $email)->first();
        if(!$user){
            $user = self::createUser(
                $email,
                null,
                $name,
                $phone
            );
            Auth::loginUsingId($user->id);
        }else{
            $user->phone = $phone;
            $user->name  = $name;
            $user->save();
        }
        return $user;
    }

}