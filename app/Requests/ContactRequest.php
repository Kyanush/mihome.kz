<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'phone'   => 'max:255|required|phone',
            'email'   => 'max:255|required',
            'message' => 'max:1000|required'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'phone'   => "'Телефон'",
            'email'   => "'E-mail'",
            'message' => "'Сообщение'",
        ];
    }

}