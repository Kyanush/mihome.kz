<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'password'              => ['string','min:6','confirmed', 'required'],
            'password_confirmation' => ['string','min:6', 'required'],
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'password' => "'Новый пароль'",
            'password_confirmation' => "'Повторите пароль'"
        ];
    }

}