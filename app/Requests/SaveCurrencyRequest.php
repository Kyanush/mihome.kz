<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SaveCurrencyRequest extends FormRequest
{

    public function rules()
    {
        $currency_id = $this->input('currency.id');

        return [
            'currency.id'      => ($currency_id ? 'exists:users,id' : 'nullable'),
            'currency.name'    => ['required', 'unique:currencies,name' . ($currency_id ? (',' . $currency_id . ',id') : '')],
            'currency.value'   => 'required|min:1',
            'currency.iso'     => ['required', 'unique:currencies,iso' . ($currency_id ? (',' . $currency_id . ',id') : '')],
            'currency.default' => 'integer|required'
        ];


    }

    public function attributes()
    {
        return [
            'currency.id'      => "''",
            'currency.name'    => "'Название'",
            'currency.value'   => "'Значение'",
            'currency.iso'     => "'ISO'",
            'currency.default' => "'По умолчанию'"
        ];
    }

}