<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SaveAccountEditRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'account.name'    => 'required|max:255',
            'account.surname' => 'max:255',
            'account.phone'   => 'required|max:25|phone',
            "account.email"   => 'required|email|unique:users,email,' . Auth::user()->id . ',id'
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'account.name'    => "'Имя'",
            'account.surname' => "'Фамилия'",
            'account.phone'   => "'Телефон'",
            "account.email"   => "'E-mail'",
        ];
    }

}