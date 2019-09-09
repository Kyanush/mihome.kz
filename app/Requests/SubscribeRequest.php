<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'product_id' => 'exists:products,id|nullable',
            'email'      => 'required|email',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'product_id' => "'Товар'",
            'email' => "'Почта'"
        ];
    }

}