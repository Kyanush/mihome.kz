<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class OneClickOrderRequest extends FormRequest
{

    public function rules()
    {
        return [
            'product_id' => ['required',
                Rule::exists('products', 'id')->where(function ($query){
                    $query->where('active', 1);
                })
            ],
            'email' => 'required|email|max:255',
            'name'  => 'required|max:255',
            'phone' => 'required|phone'
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => "'Товар'",
            'email'      => "'Email'",
            'name'       => "'Имя'",
            'phone'      => "'Телефон'"
        ];
    }

}