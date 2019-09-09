<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{

    public function rules()
    {
        $data = $this->input('user');

        $rules = [
            'user.id'      => ($data['id'] ? 'exists:users,id' : 'nullable'),
            'user.name'    => 'required|max:255',
            'user.surname' => 'max:255',
            'user.phone'   => 'max:255|phone',
            "user.email"   => 'required|email|unique:users,email' . ($data['id'] ? (',' . $data['id'] . ',id') : ''),
            'user.role_id' => 'required|exists:roles,id',
        ];

        if(empty($data['id']) or $data['password'])
        {
            $rules['user.password']              = 'required|confirmed|min:6|confirmed';
            $rules['user.password_confirmation'] = 'required|string|min:6';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'user.id' => "'ID пользователя'",
            'user.name' => "'Имя'",
            'user.surname' => "'Фамилия'",
            'user.phone'   => "'Телефон'",
            "user.email"  => "'E-mail'",
            'user.role_id' => "'Роль'",

            'user.password' => "'Пароль'",
            'user.password_confirmation' => "'Подтверждение пароля'"
        ];
    }

}