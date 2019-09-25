<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{

    public function rules()
    {
        $rules = [
            'carrier_id' => 'required|exists:carriers,id',
            'comment'    => 'max:1000',
            'payment_id' => 'required|exists:payments,id',
            'user.email' => 'required|max:255',
            'user.name'  => 'required|max:255',
            'user.phone' => 'required|phone'
        ];

        if($this->input('carrier_id', 0) == 1)
        {
            $rules['city'] = 'required|max:255';
            $rules['address'] = 'required|max:255';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'carrier_id'      => "'Способ доставки'",
            'comment'         => "'Комментарий к заказу'",
            'payment_id'      => "'Оплата'",
            'user.email'      => "'Email'",
            'user.name'       => "'Имя'",
            'user.phone'      => "'Телефон'",
            'city'            => "'Город'",
            'address'         => "'Адрес'",
        ];
    }

}
