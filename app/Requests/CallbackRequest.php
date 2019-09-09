<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CallbackRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'phone' => 'max:255|required|phone'
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'phone' => "'Телефон'"
        ];
    }

}